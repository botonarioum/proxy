<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Bot;
use App\Entity\DataLake;
use App\Repository\BotRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProxyController extends AbstractController
{
    /**
     * @Route("/proxy/{token}", name="proxy", methods={"POST"})
     * @param Request $request
     * @param string $token
     * @param BotRepository $repository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request, string $token, BotRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $bot = $repository->findOneBy(['token' => $token]);

        if (!$bot instanceof Bot) return $this->json(['status' => 'fail'], Response::HTTP_NOT_FOUND);

        $response = $client = (new Client())->post(
            $bot->getTelegramOriginWebhookUrl(),
            ['json' => json_decode($request->getContent(), true), 'http_errors' => false]);

        if ($response->getStatusCode() !== Response::HTTP_OK) return $this->json(['status' => 'fail'], $response->getStatusCode());

        $data = (new DataLake())
            ->setBotId($bot->getId())
            ->setData(json_decode($request->getContent(), true))
            ->setCreatedAt(new DateTime());

        $em->persist($data);
        $em->flush();

        return $this->json(['status' => 'ok']);
    }
}
