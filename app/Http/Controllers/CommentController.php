<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Tutorial;

class CommentController extends Controller
{

    public function create(Request $request, $id)
    {
        $this->validate($request, ['body' => 'required']);

        $comment = $request->user()->comments()->create([
            'body' => $request->json('body'),
            'tutorial_id' => $id
        ]);

        return response()->json([
            'success' => 'Anda berhasil comment'
        ], 200);
    }
}
