<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

// "token": ""3|wGzGAiysAe7W7npwqD7joXeYe7W8eHPXqHvWO6D4d0bf4532"" -> invoice
//          4|yW4H4j3eSul0zoe5ucyt4SoEkLbYCJ84fWFnvQs9326b88e2 -> user
// "email":"cbeier@example.com",
// "password":"password"

class AuthController extends Controller
{

    use HttpResponses;

    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))) {
            return $this->response('User logged in successfully', 200, [
                'token' => $request->user()->createToken('invoice', ['user-store'])->plainTextToken
            ]);
        }

        return $this->response('Invalid credentials', 403);
    }

    public function logout()
    {

    }
}
