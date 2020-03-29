<?php

declare(strict_types=1);

namespace App\Botonarioum\Domain\Commands;

use App\Entity\Bot;
use Doctrine\ORM\EntityManagerInterface;
use Formapro\TelegramBot\Bot as TelegramBot;
use Formapro\TelegramBot\SetWebhook;

class Enable
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function execute(Bot $bot): bool
    {
        $webhook = new SetWebhook($bot->getTelegramProxyWebhookUrl());
        (new TelegramBot($bot->getToken()))->setWebhook($webhook);

        $bot->setIsEnable(true);

        $this->em->persist($bot);
        $this->em->flush();

        return true;
    }
}