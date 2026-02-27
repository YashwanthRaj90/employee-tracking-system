<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeStatus;
use App\Models\EmployeeStatusHistory;
use Illuminate\Http\Request;

class EmployeeStatusController extends Controller
{
    public function assign(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'status_id' => 'required|exists:employee_statuses,id',
            'effective_from' => 'required|date'
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $status = EmployeeStatus::findOrFail($request->status_id);

        // Close old current status
        EmployeeStatusHistory::where('employee_id', $employee->id)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'effective_to' => now()
            ]);

        // Assign new status
        $history = EmployeeStatusHistory::create([
            'employee_id' => $employee->id,
            'employee_status_id' => $status->id,
            'effective_from' => $request->effective_from,
            'is_current' => true
        ]);

        return response()->json($history, 201);
    }
}