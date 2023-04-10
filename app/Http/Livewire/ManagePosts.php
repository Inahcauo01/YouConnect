<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManagePosts extends Component
{
    use WithFileUploads;

    public $post_image;
    public $post_desc;
    public $posts;

    protected $rules = [
        'post_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'post_desc' => 'required|string|max:280',
    ];

    public function mount()
    {
        $this->posts = Post::with('user')->latest()->get();
    }

    public function addPost()
    {
        $this->validate();

        $post = new Post;
        $post->post_desc = $this->post_desc;
        $post->user_id = auth()->user()->id;
        $post->post_date = now();

        if ($this->post_image) {
            $filename = time() . '.' . $this->post_image->getClientOriginalExtension();
            $this->post_image->storeAs('public/images', $filename);
            $post->post_image = $filename;
        }

        $post->save();

        $this->reset(['post_image', 'post_desc']);
        $this->posts = Post::with('user')->latest()->get();
    }

    public function deletePost(Post $post)
    {
        if (auth()->user()->id == $post->user->id) {
            $post->delete();
            $this->posts = Post::with('user')->latest()->get();
        }
    }

    public function render()
    {
        return view('livewire.manage-posts');
    }
}
