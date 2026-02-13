<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $tmp;
    public $reason;
    public $targetType;

    public function __construct($tmp, $reason = null, $targetType = 'hotel')
    {
        $this->tmp = $tmp;
        $this->reason = $reason;
        $this->targetType = $targetType;
    }

    public function build()
    {
        return $this->subject("Your {$this->targetType} application has been rejected")
            ->markdown('emails.rejected');
    }
}
