<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FollowNotifications;

class Follow extends Component
{

    public $user;


    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.follow');
    }

    public function follow()
    {
        auth()->user()->following()->attach($this->user);
        Notification::send($this->user, new FollowNotifications(auth()->user()->name, auth()->id()));
        $this->user = $this->user->fresh();
    }

    public function unfollow()
    {
        auth()->user()->following()->detach($this->user);
        $this->user = $this->user->fresh();
    }
    
}
