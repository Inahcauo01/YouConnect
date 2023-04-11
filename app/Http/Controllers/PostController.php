<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('feed', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validate([
            'post_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = new Post;

        if ($request->hasFile('post_image')) {
            $image    = $request->file('post_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $post->post_image = $filename;
        }

        $post->post_desc = $request->post_desc;
        $post->user_id   = auth()->user()->id;
        $post->post_date = now();
        $post->save();
        
        return redirect()->route('feed')->with('success', 'Post added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $validatedData = $request->validate([
            'post_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'post_desc' => 'nullable',
            'post_date' => 'date',
        ]);

        $post = Post::findOrFail($id);

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            $post->post_image = $filename;
        }

        $post->post_desc = $validatedData['post_desc'];
        $post->post_date = $validatedData['post_date'];
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('feed')->with('success', 'Le post a bien été supprimé.');
    }
}
