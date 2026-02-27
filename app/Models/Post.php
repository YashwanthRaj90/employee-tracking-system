<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    'designation_id',
    'sanctioned_strength',
    'effective_from',
    'effective_to',
    'is_active'
];
public function designation()
{
    return $this->belongsTo(Designation::class);
}

public function assignments()
{
    return $this->hasMany(EmployeePostAssignment::class);
}
}
