<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LoginResource;


class AuthController extends ApiBaseController
{
    public function login(LoginRequest $request)
    {
        $credential = $request->only('username', 'password');

        if (!Auth::attempt($credential)) {
            return $this->notFoundResponse('Useraname dan password tidak ditemukan dalam sistem.');
        }

        $request->session()->regenerate();

        $user = $request->user();
        $tokenResult = $user->createToken('api-token');
        $token = $tokenResult->plainTextToken;

        $cookie = cookie('isLoggedIn', true, 120);

        return $this->loggedResponse(new LoginResource($user, $token));
    }

    public function getUser(Request $request)
    {
        return $this->loggedResponse(new LoginResource($request->user(), '-'));
    }

    public function logout(Request $request)
    {
        $cookie = cookie('isLoggedIn', false, -1);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->successResponse('user berhasil logout');
    }
}
