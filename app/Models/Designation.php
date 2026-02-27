<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
    'name',
    'code'
];
public function posts()
{
    return $this->hasMany(Post::class);
}
}
