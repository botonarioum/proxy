<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\WebhookUrlPairs;
use App\Messages\RedirectThisMessage;
use App\Repository\WebhookUrlPairsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProxyController extends AbstractController
{
    /**
     * @Route("/api/proxy/{uuid}", name="proxy", methods={"POST"})
     * @param Request $request
     * @param string $uuid
     * @param WebhookUrlPairsRepository $repository
     * @param MessageBusInterface $bus
     * @return JsonResponse
     */
    public function proxy(
        Request $request,
        string $uuid,
        WebhookUrlPairsRepository $repository,
        MessageBusInterface $bus
    ): JsonResponse {
        $originWebhookUrl = $repository->findOneBy(['uuid' => $uuid]);

        if (!$originWebhookUrl instanceof WebhookUrlPairs) {
            return $this->json(['status' => 'fail'], Response::HTTP_NOT_FOUND);
        }

        $bus->dispatch(
            new RedirectThisMessage(
                $uuid,
                $originWebhookUrl->getOriginalWebhookUrl(),
                json_decode($request->getContent(), true),
            )
        );

        return $this->json([]);
    }
}
