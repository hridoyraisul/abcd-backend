<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| USER Routes
|--------------------------------------------------------------------------
|
| Here is where you can register USER routes for your application.
|
*/


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::post('userLogout', [UserController::class, 'userLogout']);
    Route::post('userRegister', [UserController::class, 'userRegister']);
});
Route::post('userLogin', [UserController::class, 'userLogin']);


/*
|--------------------------------------------------------------------------
| STUDENTS Routes
|--------------------------------------------------------------------------
|
| Here is where you can register USER routes for your application.
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('createStudent', [StudentController::class, 'createStudent']);
    Route::get('allStudents', [StudentController::class, 'allStudents']);
    Route::get('getStudent/{student}', [StudentController::class, 'getStudent']);
    Route::post('updateStudent/{student}', [StudentController::class, 'updateStudent']);
    Route::get('deleteStudent/{student}', [StudentController::class, 'deleteStudent']);
});


/*
|--------------------------------------------------------------------------
| ATTENDANCE Routes
|--------------------------------------------------------------------------
|
| Here is where you can register USER routes for your application.
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('createAttendance', [AttendanceController::class, 'createAttendance']);
    Route::get('currentMonthAttendances', [AttendanceController::class, 'currentMonthAttendances']);
    Route::get('studentAttendance/{student}', [AttendanceController::class, 'studentAttendance']);
});
