<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Post;
use App\Models\EmployeePostAssignment;
use App\Models\EmployeeStatusHistory;
use App\Models\EmployeeStatus;
use Illuminate\Http\Request;

class EmployeePostAssignmentController extends Controller
{
    public function assign(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'post_id' => 'required|exists:posts,id',
            'from_date' => 'required|date'
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $post = Post::findOrFail($request->post_id);

        // 1️⃣ Employee must be active
        if (! $employee->is_active) {
            return response()->json(['message' => 'Employee is not active'], 400);
        }
        // 🔎 Check current employee status
        $currentStatus = EmployeeStatusHistory::where('employee_id', $employee->id)
            ->where('is_current', true)
            ->with('status')
            ->first();

        if (! $currentStatus) {
            return response()->json(['message' => 'Employee has no active status'], 400);
        }

        // Allow only WORKING or CONTRACT
        $allowedStatuses = ['WORKING', 'CONTRACT'];

        if (! in_array($currentStatus->status->code, $allowedStatuses)) {
            return response()->json(['message' => 'Employee status does not allow post assignment'], 400);
        }
        // 2️⃣ Post must be active
        if (! $post->is_active) {
            return response()->json(['message' => 'Post is not active'], 400);
        }

        // 3️⃣ Check sanctioned strength
        $currentCount = EmployeePostAssignment::where('post_id', $post->id)
            ->where('is_current', true)
            ->count();

        if ($currentCount >= $post->sanctioned_strength) {
            return response()->json(['message' => 'Sanctioned strength exceeded'], 400);
        }

        // 4️⃣ Close old assignment if exists
        EmployeePostAssignment::where('employee_id', $employee->id)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'to_date' => now()
            ]);

        // 5️⃣ Create new assignment
        $assignment = EmployeePostAssignment::create([
            'employee_id' => $employee->id,
            'post_id' => $post->id,
            'from_date' => $request->from_date,
            'is_current' => true
        ]);

        return response()->json($assignment, 201);
    }
}
