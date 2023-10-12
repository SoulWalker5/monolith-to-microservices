<?php

namespace App\Http\Controllers;

use App\Models\Link;
use DiKay\UserService;

class LinkController extends Controller
{
    public function __construct(public readonly UserService $userService)
    {
    }

    public function show($code, UserService $userService)
    {
        $link = Link::with('products')->where('code', $code)->first();

        $user = $this->userService->get('user/' . $link->user_id);

        $link['user'] = $user;

        return $link;
    }
}
