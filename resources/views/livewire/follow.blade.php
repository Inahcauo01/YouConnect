<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="friend-details">
        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
        <small class="follow-stats d-flex align-items-center mb-1">
            <span class="text-secondary me-3">{{ $user->following()->count() }} Following</span>
            <span class="text-secondary">{{ $user->follower()->count() }} Followers</span>
        </small>


        {{-- <button wire:click="toggleFollow()" class="btn btn-sm btn-info rounded-pill px-3 text-white">
            @if ($user->following->contains(auth()->user()->id))
                <i class="fa-solid fa-check"></i> Suivi(e)
            @else
                <i class="fa-solid fa-plus"></i> Suivre
            @endif  
        </button> --}}
        
        
        @if ($user->follower->contains(auth()->user()->id))
            <button wire:click="unfollow()" class="btn btn-sm btn-info rounded-pill px-3 text-white"><i class="fa-solid fa-check"></i> Suivi(e)</button>
        @else
            <button wire:click="follow()" class="btn btn-sm btn-info rounded-pill px-3 text-white"><i class="fa-solid fa-plus"></i> Suivre</button>
        @endif  
    </div>
    
</div>
