<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class ManagePosts extends Component
{

    public $posts;

    public function mount(){
        $this->posts = Post::with('user')->latest()->get();
    }

    public function deletePost($postId){
        $post = Post::findOrFail($postId);
        if ($post->post_image) {
            Storage::delete('public/images/'.$post->post_image);
        }
        $post->delete();
        $this->mount(); // refresh posts
    }

    public function render()
    {
        return view('livewire.manage-posts');
    }
}
