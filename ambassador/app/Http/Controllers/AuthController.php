<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Order;
use DiKay\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(public readonly UserService $userService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only('first_name', 'last_name', 'email', 'password') + ['is_admin' => 0];

        $user = $this->userService->post('register', body: $data);

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']) + ['scope' => 'ambassador'];

        $response = $this->userService->post('login', body: $data);

        $cookie = Cookie::make('jwt', $response['jwt'], 60 * 24); // 1 day

        return response(['message' => 'success'])->withCookie($cookie);
    }

    public function user()
    {
        $user = $this->userService->get('user');

        $user['revenue'] = Order::where('user_id', $user['id'])->sum('total');

        return $user;
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        $this->userService->post('logout');

        return response(['message' => 'success'])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $this->userService->put('user', body: $request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $this->userService->put('user', body: $request->only('password'));

        return response($user, Response::HTTP_ACCEPTED);
    }
}
