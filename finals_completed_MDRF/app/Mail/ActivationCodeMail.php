<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

   public $activationCode;
public $name;

public function __construct($activationCode, $name)
{
    $this->activationCode = $activationCode;
    $this->name = $name;
}

public function build()
{
    return $this->subject('Activation Code')
                ->view('emails.registration')
                ->with([
                    'activationCode' => $this->activationCode,
                    'name' => $this->name,
                ]);
}
}
