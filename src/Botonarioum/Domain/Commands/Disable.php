<?php

declare(strict_types=1);

namespace App\Botonarioum\Domain\Commands;

use App\Entity\WebhookUrlPairs;
use Formapro\TelegramBot\Bot;
use Formapro\TelegramBot\SetWebhook;

class Disable
{
    public function __invoke(Bot $bot, WebhookUrlPairs $urlPairs)
    {
        $bot->setWebhook(new SetWebhook($urlPairs->getOriginalWebhookUrl()));

        return true;
    }
}