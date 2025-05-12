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
        Schema::table('student_user_detials', function (Blueprint $table) {
            //
            $table->string('cnic_file')->nullable()->after('cnic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_user_detials', function (Blueprint $table) {
            //
            $table->dropColumn('cnic_file');
        });
    }
};