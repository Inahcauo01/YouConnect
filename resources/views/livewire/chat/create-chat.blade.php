    <div style="margin-top: 7rem">
        {{-- Be like water. --}}
        @foreach ($users as $user)
            @if ($user->follower->contains(auth()->user()->id) || $user->following->contains(auth()->user()->id))
                <button class="d-flex align-items-center border-bottom pb-3 mb-2 w-100" wire:click="checkconversation({{$user->id}})">
                {{-- <a class="d-flex align-items-center border-bottom pb-3 mb-2 w-75 m-auto" href="{{ route('conversation-show', $user->id) }}"> --}}
                    {{-- <a href="{{ route('profiles.show', $user->id ) }}"> --}}
                    <span>
                        <img src="{{ $user->profile_photo_url }}" spanlt="User Avatar" class="rounded-circle me-3 shadow-sm" style="width: 40px">
                    </span>
                    <div class="friend-details d-flex justify-content-between align-items-center w-100 m-2">
                        <h3>{{ $user->name }}</h3>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
