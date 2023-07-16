<?php

namespace Inventas\ContactSupport\Mailable;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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
     * Build the message.
     *
     * @throws Exception
     */
    public function build()
    {
        $this->view('contact-support::emails.raw');
    }
}
