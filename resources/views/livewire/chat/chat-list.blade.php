<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @php
        // $users = User::all();
        $users = \App\Models\User::all();

    @endphp
    <h5 class="m-2">Mes contacts</h5>
    @foreach ($users as $user)
        @if ($user->follower->contains(auth()->user()->id) || $user->following->contains(auth()->user()->id))
            <li class="d-flex align-items-center border-bottom pb-3 mb-2">
                <a href="{{ route('profiles.show', $user->id ) }}">
                    <img src="{{ $user->profile_photo_url }}" alt="User Avatar" class="rounded-circle me-3 shadow-sm" style="width: 40px">
                </a>
                <div class="friend-details d-flex justify-content-between align-items-center w-100">
                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <small class="rounded-pill bg-info p-1 px-2">20</small>
                </div>
            </li>
        @endif
    @endforeach
</div>
