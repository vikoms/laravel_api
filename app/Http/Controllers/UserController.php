<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $id = $request->user()->id;
        return User::with('comments')->where('id', $id)->first();
    }
}
