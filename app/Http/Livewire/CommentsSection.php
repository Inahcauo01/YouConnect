<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CommentNotifications;

class CommentsSection extends Component
{

    public $postId;
    public $comments;
    public $content;
    public $newComment;
    public $editingCommentId;
    public $editedComment = [];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->comments = Post::find($postId)->comments;
        
        $this->editingCommentId = null;

        foreach ($this->comments as $comment) {
            $this->editedComment[$comment->id] = '';
        }

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

        $post = Post::find($this->postId);
        if ($post->user_id != auth()->user()->id)
            Notification::send(Post::find($this->postId)->user, new CommentNotifications($this->postId, auth()->user()->name, $comment->content));
        $this->dispatchBrowserEvent('commentAdded');
    }

    public function editComment($commentId)
    {
        $this->editingCommentId = $commentId;
        $this->editedComment[$commentId] = Comment::find($commentId)->content;
    }

    public function updateComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $editedComment = trim($this->editedComment[$commentId]);

        if (empty($editedComment)) {
            $comment->delete();
        } else {
            $comment->content = $editedComment;
            $comment->save();
        }

        $this->comments = Post::find($this->postId)->comments;

        $this->editingCommentId = null;
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
