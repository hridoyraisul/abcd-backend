<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function createAttendance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'student_id' => 'required|exists:students,id',
                'user_id' => 'required|exists:users,id',
                'status' => 'required|in:true,false',
            ]);
            if ($validator->fails()) {
                return Utility::validationResponse($validator);
            }
            $attendance = new Attendance();
            $attendance->student_id = $request->student_id;
            $attendance->user_id = $request->user_id;
            $attendance->status = $request->status;
            $attendance->save();
            return Utility::successResponse('Attendance Created Successfully', $attendance);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function currentMonthAttendances(Request $request)
    {
        try {
            $attendances = Attendance::query()->whereMonth('created_at', date('m'))->paginate(10);
            return Utility::successResponse('Attendances List', $attendances);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function studentAttendance(Student $student)
    {
        try {
            $attendances = Attendance::query()->where('student_id', $student->id)->paginate(10);
            return Utility::successResponse('Student Attendances List', $attendances);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }
}
