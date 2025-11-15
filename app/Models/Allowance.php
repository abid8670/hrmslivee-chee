<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employees_id',
        'name',
        'amount',
        'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employees_id');
    }
}
