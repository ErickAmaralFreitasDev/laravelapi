<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// "token": ""3|wGzGAiysAe7W7npwqD7joXeYe7W8eHPXqHvWO6D4d0bf4532"" -> invoice
//          4|yW4H4j3eSul0zoe5ucyt4SoEkLbYCJ84fWFnvQs9326b88e2 -> user
//          5|zhgTTFSzmdORkzP1XNlMuYpeQCTPIzRbMTO3Wfsxd53b4a69 -> teste
// "email":"cbeier@example.com",
// "password":"password"

class AuthController extends Controller
{

    use HttpResponses;

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            $token = $user->createToken('auth_token', ['user-get', 'teste-index', 'all-user-get', 'invoice-store', 'invoice-update'])->plainTextToken;
            
            return $this->response('User logged in successfully', 200, [
                'token' => $token,
                'abilities' => ['user-get', 'teste-index', 'all-user-get', 'invoice-store', 'invoice-update']
            ]);
        }

        return $this->response('Invalid credentials', 403);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->response('User Revoked', 200);
    }
}
