<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialDocument extends Model
{
    protected $fillable = [
    'employee_id',
    'document_type',
    'language',
    'document_date',
    'financial_year',
    'month'
];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
