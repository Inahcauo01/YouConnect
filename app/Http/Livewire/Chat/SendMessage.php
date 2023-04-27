<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;

class SendMessage extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $body;

    protected $listeners = ['updateSendMessage'];

    public function updateSendMessage(Conversation $conversation, User $receiver)
    {
        // dd($conversation, $receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance     = $receiver;
    }

    public function sendMessage()
    {
        if($this->body == null){
            return null;
        }
        // dd($this->body);
        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id'       => auth()->id(),
            'receiver_id'     => $this->receiverInstance->id,
            'body'            => $this->body,
        ]);

        $this->selectedConversation->last_time_message = $createdMessage->created_at;
        $this->selectedConversation->save();

        $this->emitTo('chat.chatbox','pushMessage',$createdMessage->id);
        // actualiser chatlist
        $this->emitTo('chat.chat-list','refresh');

        $this->reset('body');
    }


    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
