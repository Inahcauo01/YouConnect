<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class Chatbox extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $paginateVar = 10;
    public $messages;
    public $message_count;
    
    protected $listeners = ['chargerConversation'];

    public function pushMessage()
    {
        # code...
    }

    public function chargerConversation(Conversation $conversation, User $receiver)
    {
        // dd($conversation,$receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance     = $receiver;

        $this->message_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
                            ->skip($this->message_count - $this->paginateVar)
                            ->take($this->paginateVar)->get();
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
