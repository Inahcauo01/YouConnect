<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profiles.show');
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
    public function store(StoreProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    
     public function show($id)
     {
        $profile = Profile::where('id_user', $id)->first();
        $user = User::where('id', $id)->first();

        $posts = Post::where('user_id', $id)->get();

        return view('profiles.show', [
            'profile' => $profile,
            'posts' => $posts,
            'user' => $user,
        ]);
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
