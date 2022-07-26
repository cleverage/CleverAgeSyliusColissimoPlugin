<?php

namespace CleverAge\SyliusColissimoPlugin\Controller\Shop;

use CleverAge\SyliusColissimoPlugin\Controller\ActionInterface;
use CleverAge\SyliusColissimoPlugin\Service\SearchPickupPointService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PickupPointSearchByIdAction implements ActionInterface
{
    private SearchPickupPointService $searchPickupPointService;

    public function __construct(
        SearchPickupPointService $searchPickupPointService
    ) {
        $this->searchPickupPointService = $searchPickupPointService;
    }

    public function __invoke(Request $request): Response
    {
        if (!$pickupPointId = $request->get('pickupPointId')) {
            throw new NotFoundHttpException('pickupPointId param not found.');
        }

        $pickupPoint = $this->searchPickupPointService->byId((string) $pickupPointId);

        if (null === $pickupPoint) {
            throw new NotFoundHttpException("Pickup point not found for id '$pickupPointId'");
        }

        return new JsonResponse($pickupPoint->getData());
    }
}
