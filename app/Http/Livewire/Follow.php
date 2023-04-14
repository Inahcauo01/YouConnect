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
    
}
