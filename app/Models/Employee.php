<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'designation_id', 'employee_title_id', 'employee_shift_id'];

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

}
