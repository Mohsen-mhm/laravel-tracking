<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('request_logs', 'url')) {
            Schema::table('request_logs', function (Blueprint $table) {
                $table->text('url')->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('request_logs', 'url')) {
            Schema::table('request_logs', function (Blueprint $table) {
                $table->string('url')->change();
            });
        }
    }
};