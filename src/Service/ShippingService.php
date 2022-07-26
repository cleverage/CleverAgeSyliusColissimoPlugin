<?php

namespace CleverAge\SyliusColissimoPlugin\Service;

use CleverAge\SyliusColissimoPlugin\Exception\ShippingRequestException;
use CleverAge\SyliusColissimoPlugin\Model\Shipping\Label;
use CleverAge\SyliusColissimoPlugin\Model\Shipping\Letter\Sender;
use CleverAge\SyliusColissimoPlugin\Model\Shipping\Response\LabelResponse;
use Symfony\Component\HttpFoundation\Request;

class ShippingService extends AbstractService
{
    private const URL = '/sls-ws/SlsServiceWSRest/2.0/generateLabel';

    public function call(Label $label): LabelResponse
    {
        $letter = $label->getLetter();
        if (null === $letter->getSender()) {
            $this->manageSender($label);
        }

        $service = $letter->getService();
        if (null === $service->getCommercialName()) {
            $service->setCommercialName($this->getColissimoParams()->getCommercialName());
        }

        return $this->doCall(Request::METHOD_POST, self::URL, $label->toArray());
    }

    private function manageSender(Label $label): void
    {
        $params = $this->getColissimoParams();

        $sender = (new Sender())
            ->setCompanyName($params->getCompanyName())
            ->setLine0($params->getLine0() ?? '')->setLine1($params->getLine1() ?? '')
            ->setLine2($params->getLine2())->setLine3($params->getLine3() ?? '')
            ->setCountryCode($params->getCountryCode())
            ->setZipCode($params->getZipCode())
            ->setCity($params->getCity());

        $label->getLetter()->setSender($sender);
    }

    public function parseResponse($response): LabelResponse
    {
        $responses = $this->slsResponseParser->parse($response);

        $labelV2Response = $responses[0]['body']['labelV2Response'];
        if (null === $labelV2Response) {
            $errors = [];
            foreach ($responses[0]['body']['messages'] as $message) {
                $errors[] = $message['messageContent'] . ', ';
            }

            throw new ShippingRequestException(implode('', $errors));
        }

        return (new LabelResponse())->populate($labelV2Response);
    }

    public function validateDataBeforeCall(array $dataToValidate): void
    {
    }

    public function parseErrorCodeAndThrow(int $errorCode): void
    {
    }
}
