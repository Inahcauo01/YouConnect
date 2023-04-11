<?php

// namespace App\Http\Livewire;

// use Livewire\Component;
// use App\Models\Post;

// class LikesList extends Component
// {
//     public $post;

//     public function mount($postId)
//     {
//         $this->post = Post::find($postId);
//     }

//     public function render()
//     {
//         if (!$this->post) {
//             return view('livewire.posts');
//         }

//         return view('livewire.likes-list', [
//             'likes' => $this->post->likes()->with('user')->get()
//         ]);
//     }
// }
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class LikesList extends Component
{
    public $post;

    public function mount($postId)
    {
        $this->post = Post::find($postId);
    }

    public function render()
    {
        if (!$this->post) {
            return view('livewire.posts');
        }

        return view('livewire.likes-list', [
            'likes' => $this->post->likes()->with('user')->get()
        ]);
    }
}
