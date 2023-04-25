<div class="container">
    {{-- Success is as dangerous as failure. --}}
    <div class="chat-container row">
        <div class="chat-list-container col-3">
            @livewire('chat.chat-list')
        </div>
        <div class="chat-box-container col-9 border">
            <livewire:chat.chatbox>
            
            <livewire:chat.send-message>
        </div>
    </div>
</div>
