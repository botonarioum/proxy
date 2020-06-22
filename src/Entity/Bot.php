<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(attributes={"pagination_enabled"=true})
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass="App\Repository\BotRepository")
 */
class Bot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="bigint")
     */
    private $telegram_user_id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $telegram_bot_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_enable;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telegram_origin_webhook_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telegram_proxy_webhook_url;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class)
     */
    private $groups;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTelegramUserId(): ?int
    {
        return $this->telegram_user_id;
    }

    public function setTelegramUserId(int $telegram_user_id): self
    {
        $this->telegram_user_id = $telegram_user_id;

        return $this;
    }

    public function getTelegramBotId(): ?int
    {
        return $this->telegram_bot_id;
    }

    public function setTelegramBotId(int $telegram_bot_id): self
    {
        $this->telegram_bot_id = $telegram_bot_id;

        return $this;
    }

    public function getIsEnable(): ?bool
    {
        return $this->is_enable;
    }

    public function setIsEnable(bool $is_enable): self
    {
        $this->is_enable = $is_enable;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTelegramOriginWebhookUrl(): ?string
    {
        return $this->telegram_origin_webhook_url;
    }

    public function setTelegramOriginWebhookUrl(string $telegram_origin_webhook_url): self
    {
        $this->telegram_origin_webhook_url = $telegram_origin_webhook_url;

        return $this;
    }

    public function getTelegramProxyWebhookUrl(): ?string
    {
        return $this->telegram_proxy_webhook_url;
    }

    public function setTelegramProxyWebhookUrl(string $telegram_proxy_webhook_url): self
    {
        $this->telegram_proxy_webhook_url = $telegram_proxy_webhook_url;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }
}
