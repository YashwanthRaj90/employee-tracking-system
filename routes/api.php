<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePostAssignmentController;
use App\Http\Controllers\EmployeeStatusController;
use App\Http\Controllers\OfficialDocumentController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/documents', [OfficialDocumentController::class, 'store']);

    Route::get('/reports/monthly', [OfficialDocumentController::class, 'monthlyReport']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reports/hindi-competency', [OfficialDocumentController::class, 'hindiCompetency']);
});

Route::middleware(['auth:sanctum', 'role:HR Admin'])->group(function () {

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

});


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:Super Admin'])->group(function () {
    Route::get('/admin-test', function () {
        return response()->json(['message' => 'Admin access granted']);
    });
});

Route::middleware(['auth:sanctum', 'role:HR Admin'])->group(function () {
    Route::post('/assign-post', [EmployeePostAssignmentController::class, 'assign']);
    Route::post('/assign-status', [EmployeeStatusController::class, 'assign']);
});

Route::get('/test', function () {
    return response()->json(['message' => 'API working']);
});