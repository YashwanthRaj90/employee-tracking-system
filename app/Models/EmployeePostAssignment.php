<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeePostAssignment extends Model
{
   protected $fillable = [
    'employee_id',
    'post_id',
    'from_date',
    'to_date',
    'is_current'
];
public function employee()
{
    return $this->belongsTo(Employee::class);
}

public function post()
{
    return $this->belongsTo(Post::class);
}
}
