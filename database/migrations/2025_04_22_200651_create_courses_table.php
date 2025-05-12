<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., CS101
            $table->string('title'); // e.g., Introduction to Programming
            $table->text('description')->nullable();
            $table->integer('credit_hours')->default(3);
            $table->json('prerequisites')->nullable(); // JSON array of course IDs
            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

