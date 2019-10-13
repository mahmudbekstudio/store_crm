<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $service = null;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }

    public function login(LoginRequest $request) {
        return $this->response($this->service->login($request, User::ROLE_ADMIN));
    }

    public function resetPassword(ResetPasswordRequest $request) {
        return $this->response($this->service->resetPassword($request));
    }

    public function register(RegisterRequest $request) {
        return $this->response($this->service->register($request));
    }

    public function refresh(Request $request) {
        return response()->json($this->service->refresh($request));
    }

    public function logout(LogoutRequest $request) {
        return response()->json($this->service->logout($request));
    }
}
