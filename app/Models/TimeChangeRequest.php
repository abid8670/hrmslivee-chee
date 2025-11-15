<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'manager_id',
        'date',
        'check_in',
        'check_out',
        'reason',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    public function manager()
    {
        return $this->belongsTo(Employees::class, 'manager_id');
    }
}
