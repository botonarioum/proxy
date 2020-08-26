<?php

declare(strict_types=1);

namespace App\Botonarioum\Domain\Commands;

use App\Entity\WebhookUrlPairs;
use Formapro\TelegramBot\Bot;
use Formapro\TelegramBot\SetWebhook;

class Enable
{
    public function __invoke(Bot $bot, WebhookUrlPairs $urlPairs)
    {
        $bot->setWebhook(new SetWebhook($urlPairs->getProxyWebhookUrl()));

        return true;
    }
}