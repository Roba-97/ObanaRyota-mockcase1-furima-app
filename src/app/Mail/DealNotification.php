<?php

namespace App\Mail;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\ChatRoom;
     */
    protected $chatroom;

    /**
     * @var \App\Models\User;
     */
    protected $user;

    public function __construct(ChatRoom $chatroom, User $user)
    {
        $this->chatroom = $chatroom;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $chatroom = $this->chatroom;
        return $this->subject("商品の取引が完了しました")->markdown('emails.deal', [
            'dealUser' => $this->user,
            'dealItem' => $chatroom->purchase->item,
            'url' => url("/chat/$chatroom->id"),
        ]);
    }
}
