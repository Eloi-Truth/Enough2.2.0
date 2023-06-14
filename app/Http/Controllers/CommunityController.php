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
    $community->users()->attach(auth()->user()->id);
    return redirect()->route('community.show', $community->id);
}

    
}
