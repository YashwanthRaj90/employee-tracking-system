<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HindiLevel extends Model
{public $timestamps = false;
    protected $fillable = [
    'code',
    'name',
    'rank'
];
}