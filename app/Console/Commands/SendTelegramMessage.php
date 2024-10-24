<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendTelegramMessage extends Command
{
    protected $signature = 'telegram:sendMsg';

    protected $description = 'Bu buyruq yuqoridan kelgan!';

    public function handle(): void
    {
        (new \App\Actions\SendTelegramMessage())('Sent by CLI');
    }
}
