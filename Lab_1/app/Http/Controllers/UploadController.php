<?php

namespace App\Http\Controllers;

use App\Imports\StudyLoadImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function store(Request $request)
    {   
        ini_set('memory_limit', '1024M');
        set_time_limit(300);

        $request->validate([
            'file' => 'required|file'
        ]);

        $extension = strtolower($request->file('file')->getClientOriginalExtension());

        if (!in_array($extension, ['xls', 'xlsx'])) {
            return response()->json([
                'message' => 'Разрешены только файлы Excel: .xls и .xlsx'
            ], 422);
        }

        $request->file('file')->store('excel-files');

        Excel::import(new StudyLoadImport, $request->file('file'));

        return response()->json([
            'message' => 'Файл успешно загружен и обработан',
            'redirect' => '/loads'
        ]);
    }
}