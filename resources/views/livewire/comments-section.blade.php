<div>
    {{-- Be like water. --}}
    @foreach ($post->comments as $comment)
        <div class="comments">  
            @auth
                @if (auth()->user()->id === $comment->user_id)
                    <div class="comment-actions d-flex">
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar" style="width:33px;height:33px;margin:auto">
                        <div class="w-100">
                            <div class="d-flex justify-content-between ps-2">
                                <div class="comment-details">
                                    <h3>{{ $comment->user->name }}</h3>
                                    <p><small>{{ $comment->comment_date }}</small></p>
                                    <p><input id="coment-content-out-{{$comment->id}}" oninput="changeComment({{$comment->id}})" value="{{ $comment->content }}"/></p>
                                    <p>
                                        <form wire:submit.prevent="updateComment('{{ $postId }}', '{{ $comment->id }}', '{{ $editedComment }}')">
                                            <input id="edit-comment-in-{{$comment->id}}" type="text" wire:model="editedComment">
                                            <button class="edit-btn-cmt" type="update"><i class="fa-solid fa-pen-to-square p-1" style="color: #0065b877"></i></button>
                                        </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                          
                                               

                        <button wire:click="deleteComment({{ $comment->id }})" class="delet-btn-cmt"><i class="fa-solid fa-trash p-1" style="color: #0065b877;"></i></button>
                    </div>
                @else
                    <div  class="comment w-100">
                        <img src="{{ asset('images/default.png') }}" alt="User Avatar">
                        <div class="comment-details">
                            <h3>{{ $comment->user->name }}</h3>
                            <p><small>{{ $comment->comment_date }}</small></p>
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
