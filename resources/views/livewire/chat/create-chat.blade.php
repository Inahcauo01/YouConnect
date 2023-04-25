<div>
    {{-- Be like water. --}}
    <h5 class="m-2">Autres utilisateurs</h5>
    @foreach ($users as $user)
        @if ($user->follower->contains(auth()->user()->id) || $user->following->contains(auth()->user()->id))
            <button class="d-flex align-items-center border-bottom pb-3 mb-2" wire:click="checkconversation({{$user->id}})">
                <a href="{{ route('profiles.show', $user->id ) }}">
                    <img src="{{ $user->profile_photo_url }}" alt="User Avatar" class="rounded-circle me-3 shadow-sm" style="width: 40px">
                </a>
                <div class="friend-details d-flex justify-content-between align-items-center w-100 m-2">
                    <h3>{{ $user->name }}</h3>
                </div>
            </button>
        @endif
    @endforeach
</div>
