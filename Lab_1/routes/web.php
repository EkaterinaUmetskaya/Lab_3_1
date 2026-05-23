<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\StudyLoadController;

Route::get('/', function () {
    return auth()->check()
        ? redirect('/upload')
        : redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::view('/upload', 'upload')->name('upload');
    Route::view('/loads', 'loads')->name('loads');

    Route::post('/upload-excel', [UploadController::class, 'store'])->name('upload.excel');
    Route::get('/study-loads/export', [StudyLoadController::class, 'export']);
    Route::get('/study-loads', [StudyLoadController::class, 'index']);
    Route::post('/study-loads', [StudyLoadController::class, 'store']);
    Route::put('/study-loads/{studyLoad}', [StudyLoadController::class, 'update']);
    Route::delete('/study-loads/{studyLoad}', [StudyLoadController::class, 'destroy']);
});