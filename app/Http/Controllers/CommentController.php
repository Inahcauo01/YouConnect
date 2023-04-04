<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $comments = Comment::where('post_id', $post_id)->get();
        // return view('comments.index', compact('comments'));
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
    public function store(StoreCommentRequest $request, $post_id)
    {
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $post_id;
        $comment->content = $request->content;
        $comment->comment_date = now();
        $comment->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->route('feed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('feed');
    }
}
