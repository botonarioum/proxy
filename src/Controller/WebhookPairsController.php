<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\WebhookUrlPairs;
use App\Services\ProxyUrlsContainer;
use Doctrine\ORM\EntityManagerInterface;
use Formapro\TelegramBot\Bot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class WebhookPairsController extends AbstractController
{
    /**
     * @Route("/api/bot", name="register_bot", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ProxyUrlsContainer $proxyUrlsContainer
     * @return JsonResponse
     */
    public function register(
        Request $request,
        EntityManagerInterface $em,
        ProxyUrlsContainer $proxyUrlsContainer
    ): JsonResponse {
        $content = json_decode($request->getContent(), true);

//        example request data
//        [
//            'uuid'  => 'example-bot-uuid',
//            'origin_webhook_url' => 'http://example.com/update'
//        ];

        $uuid = $content['uuid'];
        $token = $content['token'];

//        put into database
//        [
//            'uuid'               => 'example-bot-uuid',
//            'origin_webhook_url' => 'http://example.com/update', <--- при проверке подключен ли бот - сверяем его активный webhook_url с этой строкой
//            'proxy_webhook_url'  => 'http://proxy-example.com/update/{uuid}'
//        ];

        try {
            $em->persist(
                new WebhookUrlPairs(
                    $uuid,
                    $proxyUrlsContainer->get() . '/' . $uuid,
                    json_decode((new Bot($token))->getWebhookInfo()->getBody()->getContents(), true)['result']['url']
                )
            );
            $em->flush();

            return $this->json(
                [
                    'uuid'   => $uuid,
                    'result' => [
                        'status'      => 'ok',
                        'description' => 'bot added to the service'
                    ]
                ]
            );
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'uuid'   => $uuid,
                    'result' => [
                        'status'      => 'fail',
                        'description' => $exception->getMessage()
                    ]
                ],
                Response::HTTP_CONFLICT
            );
        }
    }
}
