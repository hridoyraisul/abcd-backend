<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function createStudent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:students',
                'address' => 'required',
                'gender' => 'required'
            ]);
            if ($validator->fails()) {
                return Utility::validationResponse($validator);
            }
            $student = new Student();
            $student->uid = Utility::generateUID();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->address = $request->address;
            $student->gender = $request->gender;
            $student->save();
            return Utility::successResponse('Student Created Successfully', $student);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function allStudents(Request $request)
    {
        try {
            $students = Student::query()->paginate(10);
            return Utility::successResponse('Students List', $students);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function getStudent(Student $student)
    {
        try {
            return Utility::successResponse('Student Details', $student);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function updateStudent(Request $request, Student $student)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:students,email,' . $student->id,
                'address' => 'required',
                'gender' => 'required'
            ]);
            if ($validator->fails()) {
                return Utility::validationResponse($validator);
            }
            $student->name = $request->name;
            $student->email = $request->email;
            $student->address = $request->address;
            $student->gender = $request->gender;
            $student->save();
            return Utility::successResponse('Student Updated Successfully', $student);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function deleteStudent(Student $student)
    {
        try {
            $student->delete();
            return Utility::successResponse('Student Deleted Successfully');
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }
}
