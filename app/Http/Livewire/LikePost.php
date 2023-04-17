<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LikeNotifications;
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
        $this->post->refresh();

        if($this->post->user->id != auth()->user()->id)
        // $this->post->user->notify(new LikeNotifications($this->post->id, auth()->user()->name));
        Notification::send($this->post->user, new LikeNotifications($this->post->id, auth()->user()->name, $this->post->post_image));

    }

    public function unlike()
    {
        $this->post->likes()->where('user_id', auth()->id())->delete();
        $this->post->refresh();
                
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
