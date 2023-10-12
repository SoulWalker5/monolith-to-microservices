<?php

namespace App\Http\Controllers;

use DiKay\UserService;

class AmbassadorController extends Controller
{
    public function index(UserService $userService)
    {
        $users = $userService->get('users')->collect();

        return $users->filter(fn ($user) => $user['is_admin'] === 0)->values();
    }
}
