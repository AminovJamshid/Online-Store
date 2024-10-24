<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramMessage
{
    private string $token;
    private string $chatId;
    private string $url;

    public function __construct()
    {
        $this->token  = config('telegram.bots.token');
        $this->url    = "https://api.telegram.org/bot$this->token/sendMessage";
        $this->chatId = config('telegram.admin_chat_id');
    }

    public function __invoke($message): void
    {

        $url = "https://api.telegram.org/bot7032512823:AAFmnkUO_PDRF3xpJU70BgeL6DLqtmRTdzc/sendMessage";
        Http::post($url, [
            "chat_id" => "262247413",
            "text"    => $message,
        ]);








        try {
            Http::post($this->url, [
                "chat_id" => $this->chatId,
                "text"    => $message,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
