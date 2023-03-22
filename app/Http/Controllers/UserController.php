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
                return Utility::errorResponse('Unauthorized');
            }
            $user = auth()->user();
            $tokenResult = $user->createToken('Personal Access Token');
            return Utility::successResponse('User Login Successfully', [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => $tokenResult->token->expires_at,
                'user' => $user,
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
                'password' => 'required',
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
}
