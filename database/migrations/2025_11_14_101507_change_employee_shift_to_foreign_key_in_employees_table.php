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
            $table->renameColumn('employee_shift', 'employee_shift_id');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('employee_shift_id')->nullable()->change()->constrained('employee_shifts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['employee_shift_id']);
            $table->renameColumn('employee_shift_id', 'employee_shift');
        });
    }
};
