<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use Carbon\Carbon;

class Posts extends Component
{
    use WithFileUploads;

    public $post_desc;
    public $post_desc_up;
    public $post_image;

    protected $rules = [
        'post_desc' => 'required',
        'post_image' => 'image|max:1024',
    ];

    public function render()
    {
        $posts = Post::with('user')->latest()->get();
        return view('livewire.posts', ['posts' => $posts]);
    }

    // public function deletePost($postId)
    // {
    //     $post = Post::find($postId);

    //     if ($post && auth()->user()->id == $post->user->id) {
    //         $post->delete();
    //     }
    //     session()->flash('delete', 'Le post a bien été supprimé.');
    // }

    // public function updatePost($postId)
    // {
    //     $post = Post::find($postId);

    //     if($post && auth()->user()->id == $post->user->id){
    //         $post->post_desc = $this->post_desc_up;
    //         $post->save();
    //         $this->emit('postUpdated');
    //     }
        
    // }

}
