<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use SerializesModels;

    public $name;
    

    public function __construct($name)
    {
         $this->name = $name;
     
    }

    public function build()
    {
        return $this->subject('Welcome to Our Platform')
                    ->view('emails.approval_sent') // This is the view you will create for the email content
                    ->with([
                        'name' => $this->name,
                        
                    ]);
    }
}
