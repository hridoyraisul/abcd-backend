<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return Utility::validationResponse($validator);
            }
            $credentials = $request->only('email', 'password');
            if (!auth()->attempt($credentials)) {
                return Utility::errorResponse('Invalid Credentials');
            }
            $user = auth()->user();
            $token = $user->createToken('user')->plainTextToken;
            return Utility::successResponse('User Login Successfully', [
                'token' => $token,
                'user' => $user->only('id', 'name', 'email')
            ]);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function userLogout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return Utility::successResponse('User Logout Successfully');
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function userRegister(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return Utility::validationResponse($validator);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return Utility::successResponse('User Register Successfully', $user);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function allUsers(){
        try {
            $users = User::query()->paginate(10);
            return Utility::successResponse('All Users', $users);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function deleteUser(User $user){
        try {
            $name = $user->name;
            $user->delete();
            return Utility::successResponse($name.'\'s information removed successfully');
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }

    public function updateUser(User $user, Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'nullable|min:6',
            ]);
            if ($validator->fails()) {
                return Utility::validationResponse($validator);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->has('password') && $request->password != ''){
                $user->password = bcrypt($request->password);
            }
            $user->save();
            return Utility::successResponse($request->name.'\'s Information Updated Successfully!', $user);
        } catch (\Exception $e) {
            return Utility::exceptionResponse($e);
        }
    }
}
