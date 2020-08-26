<?php

declare(strict_types=1);

namespace App\Messages\Handlers;

use App\Messages\RedirectThisMessage;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class ProxyHandler implements MessageSubscriberInterface
{
    public function __invoke(RedirectThisMessage $msg)
    {
        $response = (new Client())->post(
            $msg->redirectHere,
            ['json' => $msg->postData, 'http_errors' => false]
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            var_dump('SERVER CODE RESPONSE: ' . $response->getStatusCode());
        }
    }

    public static function getHandledMessages(): iterable
    {
        yield RedirectThisMessage::class => [
            'from_transport' => 'master',
        ];
    }
}