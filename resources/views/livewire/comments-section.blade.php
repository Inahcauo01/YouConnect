<div>
    {{-- Be like water. --}}
    <div class="d-flex justify-content-end fs-6 m-0">
        <small>comments ({{ $post->comments()->count() }})</small>
    </div>
    @foreach ($post->comments as $comment)
        <div class="comments">  
            @auth
                @if (auth()->user()->id === $comment->user_id)
                    <div class="comment-actions d-flex">
                        <img src="{{ $comment->user->profile_photo_url }}" alt="User Avatar" class="rounded-full h-8 w-8 object-cover">
                        <div class="w-100">
                            <div class="d-flex justify-content-between ps-2">
                                <div class="comment-details">
                                    <h3>{{ $comment->user->name }}</h3>
                                    <p><small>{{ Carbon\Carbon::parse($comment->comment_date)->diffForHumans() }}
                                        @if ($comment->created_at != $comment->updated_at)
                                            <span>(modifié)</span>
                                        @endif
                                    </small></p>
                                    
                                    @if ($editingCommentId === $comment->id)
                                    
                                        <form wire:submit.prevent="updateComment('{{ $comment->id }}')">
                                            <p>
                                                <input id="edit-comment-in-{{$comment->id}}" type="text" wire:model.defer="editedComment.{{ $comment->id }}" class="coment-content-input border">
                                                <button class="edit-btn-cmt" type="submit"><i class="fa-solid fa-pen-to-square p-1" style="color: #0065b877"></i></button>
                                            </p>
                                        </form>
                                    
                                    @else
                                        <p>{{ $comment->content }}</p>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div>
                            @if ($editingCommentId !== $comment->id)
                                <button wire:click="editComment({{ $comment->id }})" class="edit-btn-cmt"><i class="fa-solid fa-pen p-1" style="color: #0065b877;"></i></button>
                            @endif
                                <button wire:click="deleteComment({{ $comment->id }})" class="delet-btn-cmt"><i class="fa-solid fa-trash p-1" style="color: #0065b877;"></i></button>
                        </div>
                    </div>
                @else
                    <div  class="comment w-100">
                        <img src="{{ $comment->user->profile_photo_url }}" alt="User Avatar" class="rounded-full h-8 w-8 object-cover">
                        <div class="comment-details">
                            <h3>{{ $comment->user->name }}</h3>
                            <p><small>{{ Carbon\Carbon::parse($comment->updated_at)->diffForHumans() }}
                                @if ($comment->updated_at != $comment->updated_at)
                                (modifié)
                                @endif
                            </small></p>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    @endforeach
    {{-- add comment --}}
        <form class="comment-form" wire:submit.prevent="store">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <img src="{{ asset('images/default.png') }}" alt="User Avatar">
            {{-- <img src="{{ auth()->user->profile_photo_url }}" alt="User Avatar"> --}}
            <input type="text" placeholder="Add a comment..." wire:model="newComment" name="content">
            <button type="submit" name="addComment" title="envoyer le commentaire" class="ms-1">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="25.000000pt" height="25.000000pt" viewBox="0 0 30.000000 30.000000" preserveAspectRatio="xMidYMid meet" class="SendSVG">
                    <g transform="translate(0.000000,30.000000) scale(0.100000,-0.100000)" fill="#119fff8f" stroke="none">
                        <path d="M44 256 c-3 -8 -4 -29 -2 -48 3 -31 5 -33 56 -42 28 -5 52 -13 52 -16 0 -3 -24 -11 -52 -16 -52 -9 -53 -9 -56 -48 -2 -21 1 -43 6 -48 10 -10 232 97 232 112 0 7 -211 120 -224 120 -4 0 -9 -6 -12 -14z"></path>
                    </g>
                </svg>
            </button>
        </form>

    
    
</div>
