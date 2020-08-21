<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelegramBotRepository")
 */
class TelegramBot
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private string $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $original_webhook_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $proxy_webhook_url;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $created_at;

    public function __construct(string $proxyWebhookUrl, string $originWebhookUrl)
    {
        $this->proxy_webhook_url = $proxyWebhookUrl;
        $this->original_webhook_url = $originWebhookUrl;

        $this->uuid = Uuid::uuid4()->toString();
        $this->created_at = new DateTimeImmutable();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getOriginalWebhookUrl(): ?string
    {
        return $this->original_webhook_url;
    }

    public function getProxyWebhookUrl(): ?string
    {
        return $this->proxy_webhook_url;
    }
}
