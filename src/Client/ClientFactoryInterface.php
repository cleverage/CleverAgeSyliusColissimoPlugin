<?php

namespace CleverAge\SyliusColissimoPlugin\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientFactoryInterface
{
    public function create(): HttpClientInterface;

    public function call(string $method, string $url, array $options = []): ResponseInterface;
}
