<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('community.index');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('community.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Community::create([
            'title' => $request -> title,
            'about' => $request -> about,
            'user_id' => Auth::user()-> id
        ]);
        return redirect('community');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $community = Community::findOrFail($id);

    // Verificar se o usuário está inscrito na comunidade
    if (!$community->users()->where('community_user.user_id', auth()->id())->exists()) {
        return redirect()->back()->with('error', 'Você não está inscrito nesta comunidade.');
    }
    

    return view('community.show', compact('community'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        return view('community.edit', compact('community'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Community $community)
    {
        $community->update([
            'title' => $request -> title,
            'about' => $request -> about,
        ]);
        return redirect('community');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community)
    {
        $community->delete();
        return redirect('/community');
    }

    public function subscribe(Request $request, Community $community)
    {
        $user = $request->user();
    
        if ($community->users()->where('users.id', $user->id)->exists()) {
            return redirect()->route('community.show', $community)->with('message', 'Você já está inscrito nesta comunidade.');
        }
    
        $community->users()->attach($user);
    
        return redirect()->route('community.show', $community)->with('message', 'Inscrição realizada com sucesso!');
    }

  public function showUsers(Community $community)
{
    $users = $community->users;
    return view('community.users', compact('community', 'users'));
}  
}

    

