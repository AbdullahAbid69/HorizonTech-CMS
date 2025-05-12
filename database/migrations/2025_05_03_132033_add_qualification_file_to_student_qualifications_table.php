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
        Schema::table('student_qualifications', function (Blueprint $table) {
            //
            $table->string('qualification_file')->nullable()->after('result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_qualifications', function (Blueprint $table) {
            //
            $table->dropColumn('qualification_file');
        });
    }
};