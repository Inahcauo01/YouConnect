<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;

class SendMessage extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $body;
    public $createdMessage;

    protected $listeners = ['updateSendMessage', 'dispatchMessageSent'];

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
        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id'       => auth()->id(),
            'receiver_id'     => $this->receiverInstance->id,
            'body'            => $this->body,
        ]);

        $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
        $this->selectedConversation->save();

        $this->emitTo('chat.chatbox','pushMessage',$this->createdMessage->id);
        // actualiser chatlist
        $this->emitTo('chat.chat-list','refresh');

        $this->reset('body');

        $this->emitSelf('dispatchMessageSent');
    }

    public function dispatchMessageSent()
    {
        
        broadcast(new MessageSent(auth()->user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
