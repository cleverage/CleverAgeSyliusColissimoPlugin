<?php

namespace CleverAge\SyliusColissimoPlugin\Service;

use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPoint;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPointSearchByIdModel;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPointsSearchModel;
use Sylius\Component\Core\Model\AddressInterface;

final class SearchPickupPointService
{
    private PickupPointByIdService $pickupPointByIdService;
    private PickupPointsService $pickupPointsService;

    public function __construct(
        PickupPointByIdService $pickupPointByIdService,
        PickupPointsService $pickupPointsService
    ) {
        $this->pickupPointByIdService = $pickupPointByIdService;
        $this->pickupPointsService = $pickupPointsService;
    }

    public function byId(string $pickupPointId): ?PickupPoint
    {
        $search = new PickupPointSearchByIdModel(
            $pickupPointId,
            ((new \DateTime())->add(new \DateInterval('P2D')))->format('d/m/Y'),
        );

        return $this->pickupPointByIdService->call($search);
    }

    /**
     * @return array|array<PickupPoint>
     */
    public function byCartAddress(AddressInterface $shippingAddress, array $options = []): array
    {
        $search = new PickupPointsSearchModel(
            $shippingAddress->getPostcode(),
            $shippingAddress->getCity(),
            $shippingAddress->getCountryCode(),
            ((new \DateTime())->add(new \DateInterval('P2D')))->format('d/m/Y'),
        );

        return array_map(
            static fn (PickupPoint $pickupPoint) => $pickupPoint->getData(),
            $this->pickupPointsService->call($search, $options),
        );
    }
}
