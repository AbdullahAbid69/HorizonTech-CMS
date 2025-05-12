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
        Schema::create('student_user_detials', function (Blueprint $table) {
            $table->id();
            $table->string('fatherName');
            $table->foreignId('user_id')->reference('id')->on('users');
            $table->foreignId('program_id')->reference('id')->on('programs');
            $table->string('nationality');
            $table->string('dateOfBirth');
            $table->string('cnic');
            $table->string('religion');
            $table->string('homeAddress');
            $table->string('telNo')->nullable();
            $table->string('mobileNumber');
            $table->string('fatherOccupation');
            $table->string('designation')->nullable();
            // $table->string('designation')->nullable();
            $table->string('NameOfOrg')->nullable();
            $table->string('officeAddress')->nullable();
            $table->string('fatherOfficePhone')->nullable();
            $table->string('AnyOtherContactNumber')->nullable();
            $table->string('AnnualIncome')->nullable();
            $table->string('fatherReligion')->nullable();
            $table->string('fatherNationality')->nullable();
            $table->string('fatherCnic')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->boolean('maritalStatus')->default(false);

            // $table->enum('marital', ['true', 'female', 'other'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_user_detials');
    }
};