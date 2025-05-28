<?php

namespace MohsenMhm\LaravelTracking\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateTrackingData extends Command
{
    protected $signature = 'tracking:migrate-data {--chunk=1000 : The number of records to process at once}';
    protected $description = 'Migrate existing request logs to a new database connection';

    public function handle()
    {
        $newConnection = config('tracking.database_connection');
        if (!$newConnection) {
            $this->error('No custom database connection configured for tracking.');
            $this->info('Please set TRACKING_DB_CONNECTION in your .env file.');
            return 1;
        }

        // Check if table exists in new connection, if not create it
        if (!Schema::connection($newConnection)->hasTable('request_logs')) {
            $this->info('Creating request_logs table in the new database...');
            
            Schema::connection($newConnection)->create('request_logs', function ($table) {
                $table->id();
                $table->string('method');
                $table->text('url');
                $table->text('headers')->nullable();
                $table->text('body')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->integer('response_status')->nullable();
                $table->timestamps();
            });

            $this->info('Table created successfully.');
        }

        // Count records to migrate
        $count = DB::table('request_logs')->count();
        $this->info("Found {$count} records to migrate.");

        if ($count === 0) {
            $this->info('No data to migrate.');
            return 0;
        }

        if (!$this->confirm("Do you want to migrate {$count} records to the new database?", true)) {
            return 0;
        }

        $chunkSize = (int)$this->option('chunk');
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $lastId = 0;
        $totalMigrated = 0;

        while (true) {
            $records = DB::table('request_logs')
                ->where('id', '>', $lastId)
                ->orderBy('id')
                ->limit($chunkSize)
                ->get();

            if ($records->isEmpty()) {
                break;
            }

            $lastId = $records->last()->id;
            $recordIds = $records->pluck('id')->toArray();

            // Get existing IDs in one query
            $existingIds = DB::connection($newConnection)
                ->table('request_logs')
                ->whereIn('id', $recordIds)
                ->pluck('id')
                ->toArray();

            $dataToInsert = [];
            $skipped = 0;
            foreach ($records as $record) {
                if (in_array($record->id, $existingIds)) {
                    $skipped++;
                    continue;
                }
                $dataToInsert[] = (array)$record;
            }

            if (!empty($dataToInsert)) {
                DB::connection($newConnection)
                    ->table('request_logs')
                    ->insert($dataToInsert);
            }

            $totalMigrated += count($dataToInsert);
            if ($skipped > 0) {
                $this->info(" Skipped {$skipped} existing records");
            }
            $bar->advance(count($records));

            // Free memory
            unset($records, $dataToInsert, $existingIds);
        }

        $bar->finish();
        $this->newLine();
        $this->info("Migration completed. {$totalMigrated} records were migrated.");

        // Reset the sequence in PostgreSQL
        if (DB::connection($newConnection)->getDriverName() === 'pgsql') {
            $maxId = DB::connection($newConnection)
                ->table('request_logs')
                ->max('id');
            
            DB::connection($newConnection)
                ->statement("SELECT setval('request_logs_id_seq', {$maxId})");
        }

        // Ask about cleanup
        if ($this->confirm('Do you want to keep the original table as backup?', true)) {
            $this->info('Original table preserved as backup.');
        } else {
            if ($this->confirm('Are you sure you want to delete the original table? This cannot be undone.', false)) {
                Schema::dropIfExists('request_logs');
                $this->info('Original table deleted.');
            }
        }

        return 0;
    }
}