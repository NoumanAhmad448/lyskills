<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('assignments_submission')) {
            Schema::create('assignments_submission', function (Blueprint $table) {
                // Check if the columns already exist before adding them
                $table->increments("id")->comment('Primary Key');
                $table->string('submission_file')->nullable()->comment("Student submitted file path");
                $table->string('submission_file_name')->nullable()->commment("file name");
                $table->foreignId('student_id')->nullable()->index();
                $table->boolean('is_late')->default(false)->comment('check if student has submitted late assignment');
                $table->string('score',255)->nullable()->comment('student score');
                $table->text('feedback')->nullable()->comment('instructor feedback');
                $table->text('comments')->nullable()->comment("student comments on the assignment submitions");
                $table->foreignId('assignment_id')->nullable()->index();
            });
        }
        if (Schema::hasTable('assignments')) {
            Schema::table('assignments', function (Blueprint $table) {
                // Check if the columns already exist before adding them
                $table->timestamp('due_date')->nullable()->after('title');
            });
        }
    }

    public function down()
    {
        Schema::table('assignments_submission', function (Blueprint $table) {
            // Drop the columns if they exist
            if (Schema::hasColumn('assignments', 'submission_file')) {
                $table->dropColumn('submission_file');
            }
            if (Schema::hasColumn('assignments', 'student_id')) {
                $table->dropForeign(['student_id']);
                $table->dropColumn('student_id');
            }
            if (Schema::hasColumn('assignments', 'is_late')) {
                $table->dropColumn('is_late');
            }
        });
    }
};
