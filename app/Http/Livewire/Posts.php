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
    public $post_image;

    protected $rules = [
        'post_desc' => 'required',
        'post_image' => 'image|max:1024', // maximum file size of 1MB
    ];

    public function render()
    {
        $posts = Post::with('user')->latest()->get();
        // Pour empecher l'affichage des postes supprimées
        $posts = $posts->reject(function ($post) {
            return $post->deleted_at != null;
        });
        return view('livewire.posts', ['posts' => $posts]);
    }

    public function deletePost($postId)
    {
        $post = Post::find($postId);

        if ($post && auth()->user()->id == $post->user->id) {
            $post->delete();
        }
        session()->flash('success', 'Le post a bien été supprimé.');
    }
}
