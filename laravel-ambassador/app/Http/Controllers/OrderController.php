<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\UserService;

class OrderController extends Controller
{
    public function __construct(public readonly UserService $userService)
    {
    }

    public function index()
    {
        return OrderResource::collection(Order::with('orderItems')->get());
    }
}
