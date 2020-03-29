<?php

declare(strict_types=1);

namespace App\Telegram;

use Formapro\TelegramBot\Bot;
use Formapro\TelegramBot\User;
use function Formapro\Values\get_value;
use function Formapro\Values\get_values;
use function Formapro\Values\set_values;

class GetMe
{
    public function get(Bot $bot): array
    {
        $getMeUrl = implode('/', ['https://api.telegram.org', 'bot' . $bot->getToken(), 'getMe']);

        $me = new User();
        set_values($me, json_decode(file_get_contents($getMeUrl), true)['result']);

        return get_values($me);
    }
}