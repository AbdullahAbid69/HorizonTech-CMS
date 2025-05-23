<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_assignment_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->onDelete('cascade'); // NEW: program context
            $table->foreignId('assignment_id')->constrained("assignments")->onDelete('cascade'); // NEW: program context
            $table->string("marks")->nullable();
            $table->string("file_path")->nullable();
            $table->string("remarks")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assignment_uploads');
    }
};