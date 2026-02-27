<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeHindiLevel extends Model
{public $timestamps = false;
    protected $fillable = [
        'employee_id',
        'hindi_level_id',
        'effective_from',
        'is_current'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function level()
    {
        return $this->belongsTo(HindiLevel::class, 'hindi_level_id');
    }
}
