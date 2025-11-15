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
        Schema::table('employees', function (Blueprint $table) {
            $table->renameColumn('title', 'employee_title_id');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('employee_title_id')->nullable()->change()->constrained('employee_titles')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['employee_title_id']);
            $table->renameColumn('employee_title_id', 'title');
        });
    }
};
