<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // 🔹 List Employees
    public function index()
    {
        return response()->json(Employee::latest()->paginate(10));
    }

    // 🔹 Create Employee
    public function store(Request $request)
    {
        $request->validate([
            'emp_code' => 'required|unique:employees',
            'name_en' => 'required|string',
            'dob' => 'required|date',
            'date_of_joining' => 'required|date',
        ]);

        $employee = Employee::create($request->all());

        return response()->json($employee, 201);
    }

    // 🔹 Show Single Employee
    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    // 🔹 Update Employee
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'emp_code' => 'required|unique:employees,emp_code,' . $employee->id,
            'name_en' => 'required|string',
        ]);

        $employee->update($request->all());

        return response()->json($employee);
    }

    // 🔹 Soft Deactivate (No Hard Delete)
    public function destroy(Employee $employee)
    {
        $employee->update(['is_active' => false]);

        return response()->json(['message' => 'Employee deactivated']);
    }
}