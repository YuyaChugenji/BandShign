<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Forgerpassmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->email  = $inputs['email'];
        $this->password  = $inputs['password'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->email)
            ->subject('パスワード再発行メール')
            ->view('contact.forgetmail')
            ->with([
                'email' => $this->email,
                'password' => $this->password,
            ]);
    }
}
