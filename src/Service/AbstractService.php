<?php

namespace CleverAge\SyliusColissimoPlugin\Service;

use CleverAge\SyliusColissimoPlugin\Client\ClientFactory;
use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameterInterface;
use CleverAge\SyliusColissimoPlugin\Hasher\HasherInterface;
use CleverAge\SyliusColissimoPlugin\Parser\SlsResponseParser;
use CleverAge\SyliusColissimoPlugin\Repository\ColissimoParameterRepositoryInterface;
use CleverAge\SyliusColissimoPlugin\Validator\ColissimoParamsValidator;

abstract class AbstractService
{
    protected ClientFactory $colissimoClient;
    protected ColissimoParamsValidator $validator;
    protected SlsResponseParser $slsResponseParser;
    protected ColissimoParameterRepositoryInterface $colissimoParameterRepository;
    protected HasherInterface $hasher;
    protected string $encryptionKey;

    public function __construct(
        ClientFactory $colissimoClient,
        ColissimoParamsValidator $validator,
        SlsResponseParser $slsResponseParser,
        ColissimoParameterRepositoryInterface $colissimoParameterRepository,
        HasherInterface $hasher,
        string $encryptionKey
    ) {
        $this->colissimoClient = $colissimoClient;
        $this->validator = $validator;
        $this->slsResponseParser = $slsResponseParser;
        $this->colissimoParameterRepository = $colissimoParameterRepository;
        $this->hasher = $hasher;
        $this->encryptionKey = $encryptionKey;
    }

    protected function doCall(
        string $method,
        string $url,
        array $options = []
    ) {
        $this->validateDataBeforeCall($options);

        $response = $this->colissimoClient->call($method, $url, $options);

        // For SlsService or tracking timeline we can not transform the response in xml element
        // because it's just a simple string.
        // So let's parse them.
        if (strpos($url, 'SlsServiceWSRest') || strpos($url, 'tracking-timeline-ws')) {
            return $this->parseResponse($response->getContent(false));
        }

        $xml = new \SimpleXMLElement($response->getContent());

        $return = $xml->xpath('//return');
        if (count($return) && (int) $return[0]->errorCode !== 0) {
            $this->parseErrorCodeAndThrow((int) $return[0]->errorCode);
        }

        return $this->parseResponse($xml);
    }

    abstract function validateDataBeforeCall(array $dataToValidate): void;

    abstract function parseErrorCodeAndThrow(int $errorCode): void;

    /**
     * @param string|\SimpleXMLElement $response
     *
     * @return mixed
     */
    abstract function parseResponse($response);

    protected function getColissimoParams(): ?ColissimoParameterInterface
    {
        return $this->colissimoParameterRepository->get();
    }

}
