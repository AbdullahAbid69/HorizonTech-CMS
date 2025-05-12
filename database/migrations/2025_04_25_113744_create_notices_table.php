<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $scopes = [
            'all_students', // notices by admin
            'all_faculty', // by admin
            'college',  // admin facultyy student alumini
            'program', // admin faculty of program and student
            'semester_program', // admin faculty of program and student
            'course', // subject admin and instructor for studemts of that subject
            'student', // for specfic student admin and faculty
            'faculty', // for specfic faculty by admin
            'timetable', // 
            'instructor_timetables',
        ];

        Schema::create('notices', function (Blueprint $table) use ($scopes) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('sender_id')->constrained('users');
            $table->boolean('is_admin');
            $table->enum('scope', $scopes);
            $table->foreignId('program_id')->nullable()->constrained();
            $table->string('semester', 20)->nullable();
            $table->foreignId('course_id')->nullable()->constrained();
            $table->foreignId('student_id')->nullable()->constrained('users');
            $table->foreignId('instructor_id')->nullable()->constrained();
            $table->foreignId('timetable_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};