<?php
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {

    //Authenticated user profile route.
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/students', StudentController::class);
    Route::apiResource('/student_classes', StudentClassController::class);
    Route::apiResource('/colors', ColorController::class);
    Route::apiResource('/chapters', ChapterController::class);
    Route::apiResource('/sections', SectionController::class);

    //Student progress routes.
    Route::get('/students/{student}/progress',  [StudentController::class, 'getProgress']);
    Route::post('/students/{student}/progress', [StudentController::class, 'markSection']);
    Route::delete('/students/{student}/progress/{section}', 
                    [StudentController::class, 'unmarkSection']
    );
});
