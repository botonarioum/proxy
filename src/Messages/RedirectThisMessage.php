<?php

declare(strict_types=1);

namespace App\Messages;


class RedirectThisMessage
{
    public string $redirectHere;
    public array $postData;
    public string $token;

    public function __construct(string $redirectHere, array $postData, string $token)
    {
        $this->token = $token;
        $this->redirectHere = $redirectHere;
        $this->postData = $postData;
    }
}