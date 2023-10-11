<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class AmbassadorController extends Controller
{
    public function __construct(public readonly UserService $userService)
    {
    }

    public function index()
    {
        $users = $this->userService->get('users')->collect();

        return $users->filter(fn ($user) => $user['is_admin'] === 0)->values();
    }
}
