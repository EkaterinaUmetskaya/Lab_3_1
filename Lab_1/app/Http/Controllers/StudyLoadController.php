<?php

namespace App\Http\Controllers;

use App\Models\StudyLoad;
use Illuminate\Http\Request;
use App\Exports\StudyLoadsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudyLoadController extends Controller
{
    public function index()
    {
        return StudyLoad::with('teacher')->orderByDesc('id')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'semester' => 'required|in:1,2',
            'funding_type' => 'required|in:budget,contract',
            'discipline_name' => 'required|string|max:255',
            'course' => 'nullable|string|max:20',
            'students_count' => 'nullable|integer',
            'specialty_code' => 'nullable|string|max:50',
            'groups_count' => 'nullable|numeric',
            'education_form' => 'nullable|string|max:50',
            'total_hours' => 'nullable|numeric',
        ]);

        return StudyLoad::create($data);
    }

    public function update(Request $request, StudyLoad $studyLoad)
    {
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'semester' => 'required|in:1,2',
            'funding_type' => 'required|in:budget,contract',
            'discipline_name' => 'required|string|max:255',
            'course' => 'nullable|string|max:20',
            'students_count' => 'nullable|integer',
            'specialty_code' => 'nullable|string|max:50',
            'groups_count' => 'nullable|numeric',
            'education_form' => 'nullable|string|max:50',
            'total_hours' => 'nullable|numeric',
        ]);

        $studyLoad->update($data);

        return $studyLoad;
    }

    public function export()
    {
        return Excel::download(new StudyLoadsExport, 'study-loads.xlsx');
    }

    public function destroy(StudyLoad $studyLoad)
    {
        $studyLoad->delete();
        return response()->json(['message' => 'Удалено']);
    }
}