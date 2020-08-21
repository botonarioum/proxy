<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Bot;
use App\Telegram\GetMe;
use App\Telegram\GetWebhookInfo;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Formapro\TelegramBot\Bot as TelegramBot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class BotController extends AbstractController
{
    /**
     * @Route("/api/bot/connection", name="connect_bot", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @throws Exception
     */
    public function connect(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        // example request data
        [
            'uuid'  => 'example-bot-uuid',
            'token' => 'example-bot-token'
        ];

        $uuid = $content['uuid'];
        $token = $content['token'];

        // put into database
        [
            'uuid'               => 'example-bot-uuid',
            'origin_webhook_url' => 'http://example.com/update', // <--- при проверке подключен ли бот - сверяем его активный webhook_url с этой строкой
            'proxy_webhook_url'  => 'http://proxy-example.com/update/{uuid}'
        ];

        // example response data
        [
            'uuid'   => 'example-bot-uuid',
            'result' => [
                'status'      => 'ok',
                'description' => 'connected successfully'
            ],
        ];


        try {
            $token = json_decode($request->getContent(), true)['token'];
            $proxyWebHookUrl = json_decode($request->getContent(), true)['proxy_webhook_url'];
            $userId = json_decode($request->getContent(), true)['user_id'];

            $bot = new TelegramBot($token);

            $getMe = (new GetMe())->get($bot);
            $getWebhookInfo = (new GetWebhookInfo())->get($bot);

            $botId = $getMe['id'];
            $botWebhookUrl = $getWebhookInfo['result']['url'];

            $bot = new Bot();
            $bot->setToken($token);
            $bot->setIsEnable(false);
            $bot->setTelegramUserId($userId);
            $bot->setTelegramBotId($botId);
            $bot->setTelegramOriginWebhookUrl($botWebhookUrl);         // todo: rename field
            $bot->setTelegramProxyWebhookUrl($proxyWebHookUrl);        // todo: rename field
            $bot->setComment('');
            $bot->setCreatedAt(new \DateTime());
            $bot->setUpdatedAt(new \DateTime());

            $em->persist($bot);
            $em->flush();
        } catch (UniqueConstraintViolationException $exception) {
            return $this->json(
                [
                    'status' => 'fail',
                    'error'  => $exception->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'status' => 'fail',
                    'error'  => $exception->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            [
                'status' => 'ok'
            ]
        );
    }

    /**
     * @Route("/api/bot/connection", name="disconnect_bot", methods={"DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @throws Exception
     */
    public function disconnect(Request $request, EntityManagerInterface $em): JsonResponse
    {
        //
    }

    /**
     * @Route("/api/bot/connection/{uuid}", name="connection_status", methods={"GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @throws Exception
     */
    public function status(Request $request, EntityManagerInterface $em): JsonResponse
    {
        //
    }

//    /**
//     * @Route("/read", name="get_bots", methods={"GET"})
//     * @param BotRepository $repository
//     * @return JsonResponse
//     */
//    public function read(BotRepository $repository): JsonResponse
//    {
//        return $this->json(
//            array_map(
//                function (Bot $bot) {
//                    return $bot->toArray();
//                },
//                $repository->findBy([], ['id' => 'DESC'])
//            )
//        );
//    }

//    /**
//     * @Route("/details/{bot_id}", name="get_bot_details", methods={"GET"})
//     * @ParamConverter("bot", options={"id" = "bot_id"})
//     * @param Bot $bot
//     * @return JsonResponse
//     */
//    public function detail(Bot $bot): JsonResponse
//    {
//        $telegramBot = new TelegramBot($bot->getToken());
//
//        $data = $bot->toArray();
//        $data['extra'] = [
//            'me'      => (new GetMe())->get($telegramBot),
//            'webhook' => (new GetWebhookInfo())->get($telegramBot)
//        ];
//
//        return $this->json($data);
//    }
}
