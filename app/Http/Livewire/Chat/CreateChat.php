<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class CreateChat extends Component
{
    public $users;
    public $message = 'hello chatApp';

    public function checkconversation($receiverId){
        $checkedconversation = Conversation::where('receiver_id',auth()->user()->id)->where('sender_id',$receiverId)->orWhere('receiver_id',$receiverId)->where('sender_id',auth()->user()->id);
        if($checkedconversation->count() == 0){
            $createdConversation = Conversation::create(['receiver_id'=>$receiverId , 'sender_id'=>auth()->user()->id]);
            
            $createdMessage = Message::create(['conversation_id'=>$createdConversation->id,'sender_id'=>auth()->user()->id,'receiver_id'=>$receiverId,'body'=>$this->message]);
            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();

            // dd('saved');
        }
        elseif ($checkedconversation->count() >=1) {
            dd('there is a conversation');
        }
    }

    public function render()
    {
        $this->users = User::where('id','!=',auth()->user()->id)->get();
        return view('livewire.chat.create-chat');
    }
}
