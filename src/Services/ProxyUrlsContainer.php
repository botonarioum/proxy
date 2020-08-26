<?php

declare(strict_types=1);

namespace App\Services;


class ProxyUrlsContainer
{
    private array $urls;

    public function add(string ...$urls): self
    {
        $this->urls = $urls;

        return $this;
    }

    public function get(): string
    {
        $copyUrls = $this->urls;
        shuffle($copyUrls);

        return reset($copyUrls);
    }
}