<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define the specific database name
        $specificDatabase = config("database.laravel_db");

        // Check if the database exists
        $dbExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$specificDatabase]);

        if (count($dbExists)) {
            Schema::create('languages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('iso_639_1', 2)->unique();
                $table->timestamps();
            });

            echo "✅ Table 'languages' created successfully in database '$specificDatabase'.\n";
        } else {
            echo "⚠️ Database '$specificDatabase' does not exist. Skipping table creation.\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Define the specific database name
        $specificDatabase = config("database.laravel_db");

        $dbExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$specificDatabase]);

        if (count($dbExists)) {
            Schema::dropIfExists('languages');
            echo "❌ Table 'languages' dropped from database '$specificDatabase'.\n";
        }
    }
};
