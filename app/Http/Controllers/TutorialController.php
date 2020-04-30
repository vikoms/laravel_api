<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Tutorial;

class TutorialController extends Controller
{

    public function index()
    {
        // return Tutorial::with('comments')->get();
        return Tutorial::all();
    }

    public function show($id)
    {
        $tutorial =  Tutorial::with('comments')->where('id', $id)->first();
        if (!$tutorial) {
            return response()->json([
                'error' => 'id tutorial tidak ditemukan'
            ], 404);
        }

        return $tutorial;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $tutorial = $request->user()->tutorials()->create([
            'title' => $request->json('title'),
            'slug' => Str::slug($request->json('title')),
            'body' => $request->json('body')
        ]);

        return response()->json([
            'success' => 'Tutorial berhasil ditambahkan'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // Menguji ownership tutorial


        $tut = Tutorial::find($id);

        if ($request->user()->id != $tut->user_id) {
            return response()->json([
                'error' => 'tidak boleh edit tutorial orang lain'
            ], 403);
        }

        $tut->title = $request->title;
        $tut->body = $request->body;
        $tut->save();
        return response()->json([
            'success' => 'Berhasil update data'
        ], 200);
    }

    public function destroy(Request $request, $id)
    {

        $tut = Tutorial::find($id);

        if ($request->user()->id != $tut->user_id) {
            return response()->json([
                'error' => 'tidak boleh hapus tutorial orang lain'
            ], 403);
        }

        $tut->delete();

        return response()->json([
            'success' => 'Berhasil hapus'
        ], 200);
    }
}
