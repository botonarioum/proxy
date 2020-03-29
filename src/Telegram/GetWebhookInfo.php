<?php

declare(strict_types=1);

namespace App\Telegram;

use Formapro\TelegramBot\Bot;

class GetWebhookInfo
{
    public function get(Bot $bot): array
    {
        $webhookInfo = $bot->getWebhookInfo();

        return json_decode($webhookInfo->getBody()->getContents(), true);
    }
}