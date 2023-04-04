<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        return back();
    }
}
