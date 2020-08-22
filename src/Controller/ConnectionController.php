<?php

declare(strict_types=1);

namespace App\Controller;

use App\Botonarioum\Domain\Commands\Disable;
use App\Botonarioum\Domain\Commands\Enable;
use App\Repository\WebhookUrlPairsRepository;
use Formapro\TelegramBot\Bot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConnectionController extends AbstractController
{
    /**
     * @Route("/api/bot/connect", name="connect_bot", methods={"POST"})
     * @param Request $request
     * @param Enable $cmd
     * @param WebhookUrlPairsRepository $repository
     * @return JsonResponse
     */
    public function connect(Request $request, Enable $cmd, WebhookUrlPairsRepository $repository): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $cmd(
            new Bot($content['token']),
            $repository->findOneBy(['uuid' => $content['token']])
        );

        return $this->json(
            [
                'operation' => [
                    'name'   => 'connect',
                    'status' => true
                ]
            ]
        );
    }

    /**
     * @Route("/api/bot/connect", name="disconnect_bot", methods={"DELETE"})
     * @param Request $request
     * @param Disable $cmd
     * @param WebhookUrlPairsRepository $repository
     * @return JsonResponse
     */
    public function disconnect(Request $request, Disable $cmd, WebhookUrlPairsRepository $repository): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $cmd(
            new Bot($content['token']),
            $repository->findOneBy(['uuid' => $content['token']])
        );

        return $this->json(
            [
                'operation' => [
                    'name'   => 'disconnect',
                    'status' => true
                ]
            ]
        );
    }

    /**
     * @Route("/api/bot/connect/check", name="check_connection_bot", methods={"POST"})
     * @param Request $request
     * @param WebhookUrlPairsRepository $repository
     * @return JsonResponse
     */
    public function status(Request $request, WebhookUrlPairsRepository $repository): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $webhookPairs = $repository->findOneBy(['uuid' => $content['uuid']]);

        return $this->json(
            [
                'is_connected' => $webhookPairs->enabled($content['webhook_url'])
            ]
        );
    }
}
