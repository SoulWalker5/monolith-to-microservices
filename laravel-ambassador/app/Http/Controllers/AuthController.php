<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Client\RequestException;
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
        $data = $request->only('first_name', 'last_name', 'email', 'password')
            + ['is_admin' => $request->path() === 'api/admin/register' ? 1 : 0];

        try {
            $user = $this->userService->post('register', body: $data);
        } catch (RequestException $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']) + ['scope' => $request->path() ? 'admin' : 'ambassador'];

        try {
            $response = $this->userService->post('login', body: $data);
        } catch (RequestException $e) {
            return response($e->response->json(), $e->getCode());
        }

        $cookie = Cookie::make('jwt', $response['jwt'], 60 * 24); // 1 day

        return response(['message' => 'success'])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        $headers = ['Authorization' => 'Bearer ' . $request->cookie('jwt')];

        try {
            return $this->userService->get('user', headers: $headers);
        } catch (RequestException $e) {
            return response($e->response->json(), $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        $headers = ['Authorization' => 'Bearer ' . $request->cookie('jwt')];
        $cookie = Cookie::forget('jwt');

        try {
            $this->userService->post('logout', headers: $headers);
        } catch (RequestException $e) {
            return response($e->response->json(), $e->getCode());
        }

        return response(['message' => 'success'])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $headers = ['Authorization' => 'Bearer ' . $request->cookie('jwt')];

        try {
            $user = $this->userService->put(
                path: 'user',
                body: $request->only('first_name', 'last_name', 'email'),
                headers: $headers
            );
        } catch (RequestException $e) {
            return response($e->response->json(), $e->getCode());
        }

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $headers = ['Authorization' => 'Bearer ' . $request->cookie('jwt')];

        try {
            $user = $this->userService->put(
                path: 'user',
                body: $request->only('password'),
                headers: $headers
            );
        } catch (RequestException $e) {
            return response($e->response->json(), $e->getCode());
        }

        return response($user, Response::HTTP_ACCEPTED);
    }
}
