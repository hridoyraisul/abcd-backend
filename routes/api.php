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
| User Login, Register, Logout Routes
|
*/

Route::get('allUsers', [UserController::class, 'allUsers']);
Route::delete('deleteUser/{user}', [UserController::class, 'deleteUser']);
Route::put('updateUser/{user}', [UserController::class, 'updateUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
//    Route::get('allUsers', [UserController::class, 'allUsers']);
    Route::post('userLogout', [UserController::class, 'userLogout']);
});
Route::post('userRegister', [UserController::class, 'userRegister']);
Route::post('userLogin', [UserController::class, 'userLogin']);


/*
|--------------------------------------------------------------------------
| STUDENTS Routes
|--------------------------------------------------------------------------
|
| Student CRUD Routes
|
*/

//Route::middleware('auth:sanctum')->group(function () {
    Route::post('createStudent', [StudentController::class, 'createStudent']);
    Route::get('allStudents', [StudentController::class, 'allStudents']);
    Route::get('getStudent/{student}', [StudentController::class, 'getStudent']);
    Route::put('updateStudent/{student}', [StudentController::class, 'updateStudent']);
    Route::delete('deleteStudent/{student}', [StudentController::class, 'deleteStudent']);
//});


/*
|--------------------------------------------------------------------------
| ATTENDANCE Routes
|--------------------------------------------------------------------------
|
| Student Attendance Routes
|
*/

//Route::middleware('auth:sanctum')->group(function () {
    Route::post('createAttendance', [AttendanceController::class, 'createAttendance']);
    Route::get('currentMonthAttendances', [AttendanceController::class, 'currentMonthAttendances']);
    Route::get('studentAttendance/{student}', [AttendanceController::class, 'studentAttendance']);
//});
