<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
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
        

        $data = $request->validate([
            'body' => 'required',
            'community_id' => 'required|exists:communities,id'
        ]);

        $data['user_id'] = Auth::user()->id;

        $post = Post::create($data);

        $community = Community::findOrFail($data['community_id']);
        $post->community()->associate($community);
        $post->save();

        // Resto do código, se houver

        return redirect()->route('community.show', ['community' => $data['community_id']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
            $post = Post::findOrFail($id);
            
            $request->validate([
                'body' => 'required',
            ]);
        
            $post->body = $request->input('body');
            $post->save();
        
            return redirect()->route('community.show', $post->id)->with('success', 'Post atualizado com sucesso!');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->back()->with('success', 'Post excluído com sucesso.');
    }
}
