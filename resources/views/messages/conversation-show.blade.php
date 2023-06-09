<x-app-layout>

<div class="m-auto w-75 border rounded p-4" style="margin-top: 7rem !important">
    <div class="chatbox-header">
        <li class="d-flex align-items-center border-bottom pb-3 mb-2">
            @dd($receiverInstance , $messages)
            <img src="{{ $receiverInstance->profile_photo_url}}" alt="" class="rounded-circle" style="width: 50px">
            <h3>{{$receiverInstance->name}}</h3>
        </li>
    </div>
    <div class="chatbox-body d-flex flex-column" id="chatbox-body">
        @foreach ($messages as $message)
        @if (auth()->id() == $message->sender_id)
            <div class="msg_body msg_body_sender align-self-end">
        @else
            <div class="msg_body msg_body_receiver">
        @endif
                <div wire:key='{{$message->id}}'>
                    {{ $message->body }}
                </div>
                <small class="time_date d-flex">
                    {{ $message->created_at->diffForHumans() }}
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Interface / Check"> <path id="Vector" d="M6 12L10.2426 16.2426L18.727 7.75732" stroke="#3276c3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </small>
            </div>
        @endforeach
    </div>
</div>
</x-app-layout>