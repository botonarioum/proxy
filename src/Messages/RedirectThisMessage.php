<?php

declare(strict_types=1);

namespace App\Messages;


class RedirectThisMessage
{
    public string $redirectHere;
    public array $postData;

    public function __construct(string $redirectHere, array $postData)
    {
        $this->redirectHere = $redirectHere;
        $this->postData = $postData;
    }
}