<?php
namespace App\Mail\Conversation;

use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Message
     */
    public $msg;

    /**
     * @var \App\User
     */
    public $fromUser;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $toUsers;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $msg)
    {
        $this->msg = $msg;
        $this->fromUser = $msg->user;
        $coll = $msg->conversation->subscribers->diff([$this->fromUser]);
        /** @var $user \App\User */
        if (!empty($coll)) foreach ($coll as $user) {
            if (!$user->settings->email_receive_conversation_messages) {
                $coll = $coll->diff([$user]);
            }
        }
        $this->toUsers = $coll;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->markdown('email.conversation.new-message');
    }
}
