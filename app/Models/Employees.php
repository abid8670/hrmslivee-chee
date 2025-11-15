<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Employees extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_web_user;
    }

    protected $fillable = [
        'hr_code',
        'machine_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'marital_status',
        'cnic',
        'cnic_issuance_date',
        'cnic_expiry_date',
        'religion',
        'blood_group',
        'father_or_husband_name',
        'mother_name',
        'spouse_name',
        'spouse_cnic',
        'child_1',
        'child_2',
        'employee_title_id',
        'employee_type',
        'department_id',
        'designation_id',
        'join_date',
        'grade',
        'over_time_rate',
        'employee_shift_id',
        'role',
        'work_site_type',
        'work_location_id',
        'is_mobile_user',
        'is_web_user',
        'is_distributor_compulsory_for_attendance',
        'is_mobile_device_register',
        'works_monday',
        'works_tuesday',
        'works_wednesday',
        'works_thursday',
        'works_friday',
        'works_saturday',
        'works_sunday',
        'country',
        'city',
        'address',
        'permanent_address',
        'phone_number',
        'emergency_person_name',
        'emergency_person_number',
        'emergency_relation',
        'email',
        'password',
        'bank_name',
        'account_holder_name',
        'bank_account_iban',
        'bank_account_no',
        'leave_group',
        'education',
        'hiring_documents',
        'joining_report',
        'police_verification_clearance_certificate',
        'cnic_copy',
        'educational_certificates',
        'resignation_current_employer',
        'experience_certificates',
        'date_of_confirmation',
        'is_resigned',
        'last_company',
        'relevant_experience',
        'total_work_experience',
        'reference',
        'remarks',
        'basic_salary',
        'tax',
        'probation_end_date',
        'manager_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function employeeTitle()
    {
        return $this->belongsTo(EmployeeTitle::class);
    }

    public function employeeShift()
    {
        return $this->belongsTo(EmployeeShift::class);
    }

    public function machines()
    {
        return $this->hasMany(EmployeeMachine::class, 'employees_id');
    }

    public function allowances()
    {
        return $this->hasMany(Allowance::class, 'employees_id');
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class, 'employees_id');
    }

    public function workLocation()
    {
        return $this->belongsTo(WorkLocation::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employees::class, 'manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employees::class, 'manager_id');
    }

    public function timeChangeRequests()
    {
        return $this->hasMany(TimeChangeRequest::class, 'employee_id');
    }
}
