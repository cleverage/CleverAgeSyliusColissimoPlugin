<?php

namespace CleverAge\SyliusColissimoPlugin\Service;

use CleverAge\SyliusColissimoPlugin\Exception\MissingTrackingSearchArgument;
use CleverAge\SyliusColissimoPlugin\Exception\TrackingRequestException;
use CleverAge\SyliusColissimoPlugin\Model\Tracking\Response\ParcelResponse;
use CleverAge\SyliusColissimoPlugin\Model\Tracking\Response\TrackingResponse;
use CleverAge\SyliusColissimoPlugin\Model\Tracking\TrackingSearchModel;
use Symfony\Component\HttpFoundation\Request;

class TrackingService extends AbstractService
{
    private const URL = '/tracking-timeline-ws/rest/tracking/timelineCompany';
    private const DATA = [
        'parcelNumber', 'lang',
    ];

    public function call(TrackingSearchModel $trackingSearchModel): TrackingResponse
    {
        return $this->doCall(Request::METHOD_POST, self::URL, [
            'login' => $this->hasher->decrypt($this->getColissimoParams()->getContractNumber(), $this->encryptionKey),
            'parcelNumber' => $trackingSearchModel->getParcelNumber(),
            'lang' => $trackingSearchModel->getLang(),
        ]);
    }

    public function validateDataBeforeCall(array $dataToValidate): void
    {
        $validate = $this->validator->validate($dataToValidate, self::DATA);
        if (!$validate['validate']) {
            $param = (string) $validate['exceptionParam'];
            $getter = '$trackingSearchModel->get' . ucfirst($param) . '()';

            throw new MissingTrackingSearchArgument("Missing $getter value. Please set $param to model.");
        }
    }

    public function parseResponse($response): TrackingResponse
    {
        $responses = $this->slsResponseParser->parse($response);

        $body = $responses[0]['body'];
        $status = $body['status'][0];
        if ($status['code'] !== "0") {
            throw new TrackingRequestException($status['message']);
        }

        $parcel = $body['parcel'];

        $trackingResponse = new TrackingResponse();
        $trackingResponse->setLang($body['lang'])
            ->setParcel((new ParcelResponse())->populate($parcel));

        $trackingResponse->getParcel()->setDeliveryChoice($parcel['service']['deliveryChoice']);

        return $trackingResponse;
    }

    public function parseErrorCodeAndThrow(int $errorCode): void
    {
    }
}
