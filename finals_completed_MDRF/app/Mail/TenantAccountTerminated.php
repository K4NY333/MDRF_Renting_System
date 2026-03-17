<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class TenantAccountTerminated extends Mailable
{
    use Queueable, SerializesModels;

    public $tenant;
    public $endDate;

    public function __construct($tenant, $endDate)
    {
        $this->tenant = $tenant;
           $this->endDate = Carbon::parse($endDate); 
    }

    public function build()
    {
        return $this->subject('Account Terminated as per Request')
                    ->view('emails.tenant_terminated')
                    ->with([
                        'name' => $this->tenant->name,
                        'endDate' => $this->endDate->format('F d, Y'),
                    ]);
    }
}
