{{-- <div id="{{$post->id}}">
    If you look to others for fulfillment, you will never truly be fulfilled.
    @if(auth()->check() && !$post->likes()->where('user_id', auth()->user()->id)->exists())
        <button wire:click="like">Like</button>
    @else
        <button wire:click="unlike" style="font-weight:900;font-size: 16px;color:#0065b8">Liked</button>
    @endif
    
    <button type="button" data-bs-toggle="modal" data-bs-target="#list-likes">{{ $post->likes()->count() }} </button>
    <div class="modal fade" id="list-likes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Likes for {{ $post->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($post->likes as $like)
                            <li>{{ $like->user->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
 --}}
 <div id="{{$post->id}}">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @if(auth()->check() && !$post->likes()->where('user_id', auth()->user()->id)->exists())
        <button wire:click="like">Like</button>
    @else
        <button wire:click="unlike" style="font-weight:900;font-size: 16px;color:#0065b8">Liked</button>
    @endif
    
    <button type="button" data-bs-toggle="modal" data-bs-target="#list-likes-{{ $post->id }}">{{ $post->likes()->count() }} </button>
    <div class="modal fade" id="list-likes-{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Likes for {{ $post->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($post->likes()->with('user')->get() as $like)
                            <li>{{ $like->user->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
