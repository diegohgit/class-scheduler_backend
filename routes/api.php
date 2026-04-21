<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('/students', StudentController::class);
Route::apiResource('/student_classes', StudentClassController::class);
Route::apiResource('/colors', ColorController::class);
Route::apiResource('/chapters', ChapterController::class);