<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MaintenanceRequest;

class StaffMaintenanceAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     */
    public function __construct(MaintenanceRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Maintenance Task Assigned')
                    ->view('emails.staff_maintenance_assigned');
    }
}
