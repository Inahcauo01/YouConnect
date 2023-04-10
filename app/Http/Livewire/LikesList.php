<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikesList extends Component
{
    public $post;

    public function mount($post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.likes-list', [
            'likes' => $this->post->likes()->with('user')->get()
        ]);
    }
}
