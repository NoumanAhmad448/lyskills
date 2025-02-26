<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $databases = [
            config("database.laravel_db"),
            config("database.testing_db"),
            config("database.connections")[config("database.default")]["database"]
        ];

        foreach ($databases as $database) {
            $dbExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$database]);

            if (!count($dbExists)) {
                $adminDB->statement("CREATE DATABASE `" . addslashes($database) . "`");
                echo "✅ Database '$database' created successfully.\n";
            } else {
                echo "⚠️ Database '$database' already exists. Skipping...\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $databases = [
            config("database.laravel_db"),
            config("database.testing_db"),
            config("database.connections")[config("database.default")]["database"]
        ];


        foreach ($databases as $database) {
            DB::statement("DROP DATABASE IF EXISTS `" . addslashes($database) . "`");
            echo "❌ Database '$database' dropped successfully.\n";
        }
    }
};
