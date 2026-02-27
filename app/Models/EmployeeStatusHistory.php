<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeStatusHistory extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_status_id',
        'effective_from',
        'effective_to',
        'is_current'
    ];

    public function status()
    {
        return $this->belongsTo(EmployeeStatus::class, 'employee_status_id');
    }
}