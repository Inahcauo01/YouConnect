<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @if(auth()->check() && !$post->likes()->where('user_id', auth()->user()->id)->exists())
        <button wire:click="like">Like</button>
    @else
        <button wire:click="unlike">Unlike</button>
    @endif
    <span>{{ $post->likes()->count() }} </span>
</div>