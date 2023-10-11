<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $user->update($request->only('first_name', 'last_name', 'email', 'password'));

        return response($user, Response::HTTP_ACCEPTED);
    }
}
