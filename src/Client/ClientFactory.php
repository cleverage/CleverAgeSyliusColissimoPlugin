<?php

namespace CleverAge\SyliusColissimoPlugin\Client;

use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameterInterface;
use CleverAge\SyliusColissimoPlugin\Hasher\HasherInterface;
use CleverAge\SyliusColissimoPlugin\Repository\ColissimoParameterRepositoryInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ClientFactory implements ClientFactoryInterface
{
    private const PROD_BASE_URI = 'https://ws.colissimo.fr';
    private const TEST_BASE_URI = 'https://ws-check.colissimo.fr';
    private const ALLOWED_METHODS = ['GET', 'POST'];

    private ColissimoParameterRepositoryInterface $colissimoParameterRepository;
    private HasherInterface $hasher;
    private string $encryptionKey;

    public function __construct(
        ColissimoParameterRepositoryInterface $colissimoParameterRepository,
        HasherInterface $hasher,
        string $encryptionKey
    ) {
        $this->colissimoParameterRepository = $colissimoParameterRepository;
        $this->hasher = $hasher;
        $this->encryptionKey = $encryptionKey;
    }

    public function create(): HttpClientInterface
    {
        $params = $this->getColissimoParams();

        return HttpClient::createForBaseUri(
            $params->isTestModeEnabled() ? self::TEST_BASE_URI : self::PROD_BASE_URI,
        );
    }

    public function call(
        string $method,
        string $url,
        array $options = []
    ): ResponseInterface {
        $method = strtoupper($method);
        if (!in_array($method, self::ALLOWED_METHODS, true)) {
            throw new MethodNotAllowedException(self::ALLOWED_METHODS, 'Please provide an allowed http method.');
        }

        $client = $this->create();

        $params = $this->getColissimoParams();
        $contractNumber = $this->hasher->decrypt($params->getContractNumber(), $this->encryptionKey);
        $password = $this->hasher->decrypt($params->getPassword(), $this->encryptionKey);

        $isGetMethod = Request::METHOD_GET === $method;

        $contractKey = $isGetMethod ? (
            in_array('login', $options, true) // Specific cases for TrackingService.
                ? 'login'
                : 'accountNumber'
        ) : 'contractNumber';

        $credentials = [
            $contractKey => $contractNumber,
            'password' => $password,
        ];

        if ($isGetMethod) {
            return $client->request($method, $url, [
                'query' => array_merge($credentials, $options),
            ]);
        }

        return $client->request($method, $url, [
            'json' => array_merge($credentials, $options),
            'headers' => [
                'contentType' => 'application/json',
            ],
        ]);
    }

    private function getColissimoParams(): ColissimoParameterInterface
    {
        $params = $this->colissimoParameterRepository->get();

        if (
            !$params instanceof ColissimoParameterInterface
            || !$params->getContractNumber()
            || !$params->getPassword()
        ) {
            throw new \Exception('The API is not configured in the admin Colissimo section.');
        }

        return $params;
    }
}
