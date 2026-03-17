<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomOccupiedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $room;
    public $applicant;

    public function __construct($room, $applicant)
    {
        $this->room = $room;
        $this->applicant = $applicant;
    }

    public function build()
    {
        return $this->subject('Room Application Update')
            ->view('emails.room_occupied_notification');
    }
}