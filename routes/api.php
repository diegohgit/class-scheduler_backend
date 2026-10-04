<?php
#use App\Http\Controllers\AuthController;

use App\Http\Controllers\ActiveHourController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
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

    Route::get('/students/export', [StudentController::class, 'export']);
    Route::apiResource('/students', StudentController::class);
    Route::apiResource('/student_classes', StudentClassController::class);
    //Route::get('/colors', [ColorController::class, 'index']);
    Route::apiResource('/chapters', ChapterController::class);
    Route::apiResource('/sections', SectionController::class);
    Route::apiResource('/active_hours', ActiveHourController::class);

    //Student progress routes.
    Route::get('/students/{student}/progress',  [StudentController::class, 'getProgress']);
    Route::post('/students/{student}/progress', [StudentController::class, 'markSection']);
    Route::delete('/students/{student}/progress/{section}', 
                    [StudentController::class, 'unmarkSection']
    );
});



//This route remains as public just for testing purposes.
Route::get('/colors', [ColorController::class, 'index']);

Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('throttle:6,1');

Route::post('/auth/reset-password', [ResetPasswordController::class, 'store']);