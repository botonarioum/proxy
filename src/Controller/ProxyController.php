<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Bot;
use App\Messages\RedirectThisMessage;
use App\Repository\BotRepository;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ProxyController extends AbstractController
{
    /**
     * @Route("/proxy/{token}", name="proxy", methods={"POST"})
     * @param Request $request
     * @param string $token
     * @param BotRepository $repository
     * @param MessageBusInterface $bus
     * @param LoggerInterface $logger
     * @return JsonResponse
     */
    public function index(
        Request $request,
        string $token,
        BotRepository $repository,
        MessageBusInterface $bus,
        LoggerInterface $logger
    ): JsonResponse {
        $logger->error('INIT' . PHP_EOL);

        try {
            var_dump('RABBITMQ...' . PHP_EOL);

            var_dump('PROXY...' . PHP_EOL);
            $bot = $repository->findOneBy(['token' => $token]);

            $bus->dispatch(
                new RedirectThisMessage(
                    $bot->getTelegramOriginWebhookUrl(),
                    json_decode($request->getContent(), true)
                )
            );
        } catch (Throwable $exception) {
            var_dump($exception->getMessage() . PHP_EOL);
        }
        
        if (!$bot instanceof Bot) {
            return $this->json(['status' => 'fail'], Response::HTTP_NOT_FOUND);
        }

        $response = (new Client())->post(
            $bot->getTelegramOriginWebhookUrl(),
            ['json' => json_decode($request->getContent(), true), 'http_errors' => false]
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return $this->json(['status' => 'fail'], $response->getStatusCode());
        }

        return $this->json(['status' => 'ok']);
    }
}
