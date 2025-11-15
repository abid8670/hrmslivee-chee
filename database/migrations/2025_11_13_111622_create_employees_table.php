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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('hr_code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('cnic')->nullable();
            $table->date('cnic_issuance_date')->nullable();
            $table->date('cnic_expiry_date')->nullable();
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('father_or_husband_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_cnic')->nullable();
            $table->string('child_1')->nullable();
            $table->string('child_2')->nullable();
            $table->string('title')->nullable();
            $table->string('employee_type')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->cascadeOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained('designations')->cascadeOnDelete();
            $table->date('join_date')->nullable();
            $table->string('grade')->nullable();
            $table->decimal('over_time_rate', 8, 2)->nullable();
            $table->string('employee_shift')->nullable();
            $table->string('role')->nullable();
            $table->string('work_site_type')->nullable();
            $table->string('work_location')->nullable();
            $table->boolean('is_mobile_user')->nullable();
            $table->boolean('is_web_user')->nullable();
            $table->boolean('is_distributor_compulsory_for_attendance')->nullable();
            $table->boolean('is_mobile_device_register')->nullable();
            $table->boolean('works_monday')->nullable();
            $table->boolean('works_tuesday')->nullable();
            $table->boolean('works_wednesday')->nullable();
            $table->boolean('works_thursday')->nullable();
            $table->boolean('works_friday')->nullable();
            $table->boolean('works_saturday')->nullable();
            $table->boolean('works_sunday')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('emergency_person_name')->nullable();
            $table->string('emergency_person_number')->nullable();
            $table->string('emergency_relation')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('bank_account_iban')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('leave_group')->nullable();
            $table->text('education')->nullable();
            $table->string('hiring_documents')->nullable();
            $table->string('joining_report')->nullable();
            $table->string('police_verification_clearance_certificate')->nullable();
            $table->string('cnic_copy')->nullable();
            $table->string('educational_certificates')->nullable();
            $table->string('resignation_current_employer')->nullable();
            $table->string('experience_certificates')->nullable();
            $table->date('date_of_confirmation')->nullable();
            $table->boolean('is_resigned')->nullable();
            $table->string('last_company')->nullable();
            $table->text('relevant_experience')->nullable();
            $table->text('total_work_experience')->nullable();
            $table->string('reference')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
