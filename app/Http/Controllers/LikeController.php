<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $user = $request->user();
        $post_id = $request->input('post_id');

        // Verificar se o usuário já curtiu o post
        if ($user->hasLikedPost($post_id)) {
            return response()->json(['message' => 'Você já curtiu esse post.'], 409);
        }

        // Criar o registro de like
        Like::create([
            'user_id' => $user->id,
            'post_id' => $post_id,
        ]);

        return response()->json(['message' => 'Post curtido com sucesso.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $like = Like::where('user_id', $user->id)->findOrFail($id);

        // Verificar se o like pertence ao usuário autenticado
        if ($like->user_id !== $user->id) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        // Excluir o registro de like
        $like->delete();

        return response()->json(['message' => 'Like removido com sucesso.']);
    }
}
