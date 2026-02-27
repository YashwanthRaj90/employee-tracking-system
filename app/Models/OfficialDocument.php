<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialDocument extends Model
{
    protected $fillable = [
        'employee_id',
        'document_category',
        'language',
        'subject',
        'issue_date',
        'financial_year',
        'month',
        'created_by',
        'is_locked'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}