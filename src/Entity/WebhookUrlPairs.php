<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WebhookUrlPairsRepository")
 */
class WebhookUrlPairs
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

    public function __construct(string $uuid, string $proxyWebhookUrl, string $originWebhookUrl)
    {
        $this->proxy_webhook_url = $proxyWebhookUrl;
        $this->original_webhook_url = $originWebhookUrl;
        $this->uuid = $uuid;

        $this->created_at = new DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function getOriginalWebhookUrl(): string
    {
        return $this->original_webhook_url;
    }

    /**
     * @return string
     */
    public function getProxyWebhookUrl(): string
    {
        return $this->proxy_webhook_url;
    }

    public function enabled(string $webhookUrl): bool
    {
        return $webhookUrl === $this->getProxyWebhookUrl();
    }
}
