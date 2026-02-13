<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tempPassword;
    public $targetType;


    /**
     * Create a new message instance.
     */
    public function __construct($user, $tempPassword, $targetType = 'hotel')
    {
        $this->user = $user;
        $this->tempPassword = $tempPassword;
        $this->targetType = $targetType;
    }

    public function build()
    {
        return $this->subject("Your {$this->targetType} account has been approved")
            ->markdown('emails.approved');
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Approved Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.approved',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
