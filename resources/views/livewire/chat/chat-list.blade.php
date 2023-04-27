<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @php
        $users = \App\Models\User::all();

    @endphp
    <h5 class="m-2">Mes contacts</h5>
    @if ($conversations->count() > 0)
        @foreach ($conversations as $conversation)
            <li class="d-flex align-items-center border-bottom pb-3 mb-2 chatlistclass" role="button" wire:key='{{$conversation->id}}' wire:click="$emit('selectUser', {{$conversation}}, {{$this->getUserInstance($conversation, $name='id')}})">
                <div class="friend-details d-flex justify-content-between align-items-center w-100">
                    <div>
                        {{-- <h3>{{ $conversation->user->id }}</h3> --}}
                        <h3>{{ $this->getUserInstance($conversation, $name='name') }}</h3>
                        <small>{{ $conversation->messages->last()->body}}</small>
                        {{-- <small>{{ $this->getUserInstance($conversation, $name='last_time_message') }}</small> --}}
                        {{-- @dd($this->getUserInstance($conversation, $name='last_time_message')) --}}
                    </div>
                    <small>{{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans()}}</small>
                </div>
            </li>
        @endforeach
    @else
        <p>Vous avez aucune conversation pour le moment</p>
    @endif
</div>
