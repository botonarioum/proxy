<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Bot;
use App\Handlers\BannerActionMessage;
use App\Messages\RedirectThisMessage;
use App\Repository\BotRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
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
     * @return JsonResponse
     */
    public function index(
        Request $request,
        string $token,
        BotRepository $repository,
        MessageBusInterface $bus
    ): JsonResponse {
        $bot = $repository->findOneBy(['token' => $token]);

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

        try {
            $message = (new Envelope(
                new RedirectThisMessage(
                    $bot->getTelegramOriginWebhookUrl(),
                    json_decode($request->getContent(), true)
                )
            ));

            $bus->dispatch($message);
        } catch (Throwable $exception) {
            var_dump($exception->getMessage() . PHP_EOL);
        }

        return $this->json(['status' => 'ok']);
    }
}
