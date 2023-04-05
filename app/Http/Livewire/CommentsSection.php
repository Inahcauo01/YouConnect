<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentsSection extends Component
{

    public $postId;
    public $comments;
    public $content;
    public $newComment;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->comments = Post::find($postId)->comments;
    }
    
    public function store(StoreCommentRequest $request)
    {
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $this->postId;
        $comment->content = $this->newComment;
        $comment->comment_date = now();
        $comment->save();

        $this->comments = Post::find($this->postId)->comments;
        $this->newComment = '';
        $this->dispatchBrowserEvent('commentAdded');
    }

    public function update(UpdateCommentRequest $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $comment->content = $request->content;
        $comment->save();

        $this->dispatchBrowserEvent('commentUpdated');
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        $this->comments = Post::find($this->postId)->comments;

        $this->dispatchBrowserEvent('commentDeleted');
    }

    
    public function render()
    {
        $post = Post::find($this->postId);
        return view('livewire.comments-section', [
            'post' => $post
        ]);
    }
}
