<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantTerminatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $room;
    public $tenant;

    public function __construct($room, $tenant)
    {
        $this->room = $room;
        $this->tenant = $tenant;
    }

    public function build()
    {
        return $this->subject('Room Termination Notice')
            ->view('emails.tenant_terminated_notification');
    }
}