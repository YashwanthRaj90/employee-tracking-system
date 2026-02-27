<?php

namespace App\Http\Controllers;

use App\Models\OfficialDocument;
use App\Models\Employee;
use App\Models\MonthStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OfficialDocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'document_category' => 'required|string|max:255',
            'language' => 'required|in:HINDI,ENGLISH,BILINGUAL',
            'subject' => 'nullable|string|max:255',
            'issue_date' => 'required|date'
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        // 1️⃣ Employee must be active
        if (!$employee->is_active) {
            return response()->json(['message' => 'Employee is not active'], 400);
        }

        $issueDate = Carbon::parse($request->issue_date);
        $month = $issueDate->month;
        $year = $issueDate->year;

        // 2️⃣ Financial year calculation (April–March)
        if ($month >= 4) {
            $financialYear = $year . '-' . substr($year + 1, -2);
        } else {
            $financialYear = ($year - 1) . '-' . substr($year, -2);
        }

        // 3️⃣ Check month lock
        $monthStatus = MonthStatus::where('financial_year', $financialYear)
            ->where('month', $month)
            ->first();

        if ($monthStatus && $monthStatus->is_locked) {
            return response()->json(['message' => 'This month is locked'], 400);
        }

        // 4️⃣ Create document
        $document = OfficialDocument::create([
            'employee_id' => $employee->id,
            'document_category' => $request->document_category,
            'language' => $request->language,
            'subject' => $request->subject,
            'issue_date' => $issueDate,
            'financial_year' => $financialYear,
            'month' => $month,
            'created_by' => Auth::id(),
            'is_locked' => false
        ]);

        return response()->json($document, 201);
    }

    public function monthlyReport(Request $request)
    {
        $request->validate([
            'financial_year' => 'required|string',
            'month' => 'required|integer|min:1|max:12'
        ]);

        $documents = OfficialDocument::where('financial_year', $request->financial_year)
            ->where('month', $request->month)
            ->get();

        $total = $documents->count();
        $hindi = $documents->where('language', 'HINDI')->count();
        $bilingual = $documents->where('language', 'BILINGUAL')->count();
        $english = $documents->where('language', 'ENGLISH')->count();

        $hindiPercentage = $total > 0
            ? round((($hindi + $bilingual) / $total) * 100, 2)
            : 0;

        return response()->json([
            'total_documents' => $total,
            'hindi_documents' => $hindi,
            'bilingual_documents' => $bilingual,
            'english_documents' => $english,
            'hindi_percentage' => $hindiPercentage
        ]);
    }
}