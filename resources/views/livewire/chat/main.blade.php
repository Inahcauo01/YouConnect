<div class="container" wire:poll>
    {{-- Success is as dangerous as failure. --}}
    <div class="chat-container row">
        <div class="chat-list-container col-3">
            @livewire('chat.chat-list')
            {{-- <livewire:chat.create-chat> --}}
        </div>

        <div class="chat-box-container col-9 border">
            <livewire:chat.chatbox>
            
            <livewire:chat.send-message>
        </div>
    </div>
    <script>
        window.addEventListener('chatSelected', event =>{
            $('#chatbox-body').scrollTop($('#chatbox-body')[0].scrollHeight);
            let height = $('#chatbox-body')[0].scrollHeight;
            // alert(height)
            window.livewire.emit('updateHeight', { 
                height:height,

             })
        })
    </script>
</div>
