<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="friend-details">
        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
        <small class="follow-stats d-flex align-items-center mb-1">
            <button type="button" class="text-secondary me-3" data-bs-toggle="modal" data-bs-target="#list-following-{{ $user->id }}">{{ $user->following()->count() }} Following</button>
            <button type="button" class="text-secondary me-3" data-bs-toggle="modal" data-bs-target="#list-follower-{{ $user->id }}">{{ $user->follower()->count() }} Followers</button>
        </small>
        
        @if ($user->follower->contains(auth()->user()->id))
            <button wire:click="unfollow()" class="btn btn-sm btn-info rounded-pill px-3 text-white"><i class="fa-solid fa-check"></i> Suivi(e)</button>
        @else
            <button wire:click="follow()" class="btn btn-sm btn-info rounded-pill px-3 text-white"><i class="fa-solid fa-plus"></i> Suivre</button>
        @endif
    </div>
    
    <div class="modal fade" id="list-follower-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered position-relative">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Les abonnés</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($user->follower as $follower)
                            <li>{{ $follower->name }}</li>
                        @endforeach
                        @if (!$user->follower->count())
                            <small class="d-flex flex-column text-center text-secondary">aucune personne</small>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="list-following-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Les abonnements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($user->following as $following)
                            <li>{{ $following->name }}</li>
                        @endforeach
                        @if (!$user->following->count())
                            <small class="d-flex flex-column text-center text-secondary">aucune personne</small>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
