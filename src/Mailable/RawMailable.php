<?php

namespace Inventas\ContactSupport\Mailable;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class RawMailable extends Mailable
{
    use Queueable, SerializesModels;

    public string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            text: 'contact-support::emails.raw'
        );
    }

}
