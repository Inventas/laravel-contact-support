<?php

namespace Inventas\ContactSupport\Commands;

use Illuminate\Console\Command;

class ContactSupportCommand extends Command
{
    public $signature = 'laravel-contact-support';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
