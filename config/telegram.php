<?php

declare(strict_types=1);

return [
    'bots'          => [
        'token' => env('TELEGRAM_NOTIFICATION_BOT_TOKEN'),
    ],
    'admin_chat_id' => env('ADMIN_CHAT_ID'),
];
