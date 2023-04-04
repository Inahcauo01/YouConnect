<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class LikePost extends Component
{
    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function like()
    {
        $this->post->likes()->create([
            'user_id' => auth()->id(),
        ]);
    }

    public function unlike()
    {
        $this->post->likes()->where('user_id', auth()->id())->delete();
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
