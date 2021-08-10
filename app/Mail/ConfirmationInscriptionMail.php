<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationInscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    private $sender;
    private $receiver;
    /**
     * Create a new message instance.
     *
     *
     * @return void
     */
    public function __construct($sender, $receiver)
    {
        // $this->user = $user;
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = $this->_genetate_token($this->receiver->email);
        return $this->view('mail.confirmation-inscription')->with([
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'confirmation_link' => 'http://localhost:8000/api/user/' . $this->receiver->id_inscription . '/verify?token=' . $token
        ]);
    }


    private function _genetate_token($user_email)
    {
        return bcrypt($user_email);
    }
}
