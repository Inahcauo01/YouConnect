<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

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
    
    // public function toggleFollow()
    // {
    //     if ($this->user->following->contains(auth()->user()->id)) {
    //         auth()->user()->following()->detach($this->user);
    //     } else {
    //         auth()->user()->following()->attach($this->user);
    //     }
    //     $this->user = $this->user->fresh();
    //     $this->emit('refreshComponent');
    // }


    public function follow()
    {
        auth()->user()->following()->attach($this->user);
        $this->user = $this->user->fresh();
    }

    public function unfollow()
    {
        auth()->user()->following()->detach($this->user);
        $this->user = $this->user->fresh();
    }

    // public function follow($following_id)
    // {
    //     $following = User::find($following_id);
    //     auth()->user()->followings()->attach($following);
    //     $this->user = $this->user->fresh();
    // }

    // public function unfollow($following_id)
    // {
    //     $following = User::find($following_id);
    //     auth()->user()->following()->detach($following);
    //     $this->user = $this->user->fresh();
    // }

}
