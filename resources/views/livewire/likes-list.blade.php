<div wire:poll.5ms>
    {{-- Stop trying to control. --}}
    <ul>
        @foreach ($likes as $like)
            <li>{{ $like->user->name }}</li>
        @endforeach
    </ul>
</div>
