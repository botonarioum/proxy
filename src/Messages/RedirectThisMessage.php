<?php

declare(strict_types=1);

namespace App\Messages;


class RedirectThisMessage
{
    public string $uuid;
    public string $redirectHere;
    public array $postData;

    public function __construct(string $uuid, string $redirectHere, array $postData)
    {
        $this->redirectHere = $redirectHere;
        $this->postData = $postData;
        $this->uuid = $uuid;
    }
}