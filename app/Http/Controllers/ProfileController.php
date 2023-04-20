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
    public function update(UpdateProfileRequest $request, $id)
    {
        // dd($request->input('bio'));
        $profile = Profile::findOrFail($id);
        
        $profile->titre          = $request->input('titre');
        $profile->date_naissance = $request->input('date_naissance');
        $profile->telephone      = $request->input('telephone');
        $profile->adresse        = $request->input('adresse');
        $profile->linkedin_link  = $request->input('link_linkedin');
        $profile->github_link    = $request->input('link_github');
        $profile->bio            = $request->input('bio');
        // dd($profile->bio);
        $profile->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
