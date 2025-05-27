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

                // Remove the foreign key constraint since users table is in different database
                // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
            // Use keyset pagination for better performance with large datasets
            $records = DB::table('request_logs')
                ->where('id', '>', $lastId)
                ->orderBy('id')
                ->limit($chunkSize)
                ->get();

            if ($records->isEmpty()) {
                break;
            }

            $lastId = $records->last()->id;

            $dataToInsert = [];
            foreach ($records as $record) {
                $dataToInsert[] = (array)$record;
            }

            // Insert into new database
            DB::connection($newConnection)
                ->table('request_logs')
                ->insert($dataToInsert);

            $totalMigrated += count($records);
            $bar->advance(count($records));

            // Free memory
            unset($records, $dataToInsert);
        }

        $bar->finish();
        $this->newLine();
        $this->info("Migration completed. {$totalMigrated} records were migrated.");

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