<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedconversation;

    protected $listeners = ['selectUser','refresh'=>'$refresh'];


    public function selectUser(Conversation $conversation, $receiverId)
    {
        // dd($conversation, $receiverId);
        $this->selectedconversation = $conversation;
        $this->receiverInstance = User::find($receiverId);

        $this->emitTo('chat.chatbox','chargerConversation', $this->selectedconversation,$this->receiverInstance);
        $this->emitTo('chat.send-message','updateSendMessage', $this->selectedconversation,$this->receiverInstance);
    }

    public function getUserInstance(Conversation $conversation, $request)
    {
        $this->auth_id = auth()->id();

        if ($conversation->sender_id ==$this->auth_id) {
            $this->receiverInstance = User::firstWhere('id',$conversation->receiver_id);
        }
        else {
            $this->receiverInstance = User::firstWhere('id',$conversation->sender_id);
        }
        // dd($request);
        if (isset($request)) {
            return $this->receiverInstance->$request;
        }
    }

    public function mount()
    {
        $this->auth_id = auth()->id();
        $this->conversations = Conversation::where('sender_id',$this->auth_id)->orWhere('receiver_id', $this->auth_id)
                                ->orderBy('last_time_message','DESC')->get();
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
