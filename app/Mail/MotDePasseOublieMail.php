<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class MotDePasseOublieMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    // private $expireTime = strtotime('+10 minutes');
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $hashedEmail = Hash::make($this->user->email);
        $hashedExpireDate = Hash::make($this->expireTime);

        return $this->view('view.mot_de_passe_oublie', [
            'user' => $this->user,

        ]);
    }
}
