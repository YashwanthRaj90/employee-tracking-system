<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'emp_code',
        'name_en',
        'name_hi',
        'dob',
        'date_of_joining',
        'date_of_retirement',
        'is_active'
    ];
    public function hindiLevel()
{
    return $this->hasOne(EmployeeHindiLevel::class);
}

public function courses()
{
    return $this->belongsToMany(Course::class, 'employee_courses');
}
    public function postAssignments()
    
{
    return $this->hasMany(EmployeePostAssignment::class);
}

public function statusHistory()
{
    return $this->hasMany(EmployeeStatusHistory::class);
}
}