<?php

namespace App\Mail;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        return $this->subject("商品の取引が完了しました")->markdown('emails.deal', [
            'dealUser' => $this->user,
            'dealItem' => $this->chatroom->purchase->item,
            'url' => url('/login'),
        ]);
    }
}
