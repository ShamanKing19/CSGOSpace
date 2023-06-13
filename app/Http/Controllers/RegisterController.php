<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validateResult = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email:rfc,dns|unique:users'
        ]);

        if($validateResult->fails()) {
            return \Response::error('Some of requirements are not satisfied', $validateResult->errors()->toArray());
        }

        $user = \App\Models\User::create($validateResult->validated());
        return \Response::success($user->toArray());
    }
}
