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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            // $table->string('department_id')->nullable();
            $table->foreignId('department_id')->reference('id')->on('departments');

            $table->string('designation')->nullable();
            $table->foreignId('user_id')->reference('id')->on('users');
            $table->string('final_qualification')->nullable(); // e.g., PhD, MS, etc.
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};