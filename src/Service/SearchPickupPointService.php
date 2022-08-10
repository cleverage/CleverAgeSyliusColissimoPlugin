<?php

namespace CleverAge\SyliusColissimoPlugin\Service;

use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\Enum\PickupPointReseau;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPoint;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPointSearchByIdModel;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPointsSearchModel;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Context\CartContextInterface;

final class SearchPickupPointService
{
    private PickupPointByIdService $pickupPointByIdService;
    private PickupPointsService $pickupPointsService;
    private CartContextInterface $cartContext;

    public function __construct(
        PickupPointByIdService $pickupPointByIdService,
        PickupPointsService $pickupPointsService,
        CartContextInterface $cartContext
    ) {
        $this->pickupPointByIdService = $pickupPointByIdService;
        $this->pickupPointsService = $pickupPointsService;
        $this->cartContext = $cartContext;
    }

    public function byId(string $pickupPointId): ?PickupPoint
    {
        $search = new PickupPointSearchByIdModel(
            $pickupPointId,
            ((new \DateTime())->add(new \DateInterval('P2D')))->format('d/m/Y'),
        );

        $options = [];
        $countryCode = $this->cartContext->getCart()->getShippingAddress()->getCountryCode();
        if ($countryCode !== 'FR') {
            $options['reseau'] = PickupPointReseau::getByCountryCodeAndProductCode($countryCode);
        }

        return $this->pickupPointByIdService->call($search, $options);
    }

    /**
     * @return array|array<PickupPoint>
     */
    public function byCartAddress(AddressInterface $shippingAddress, array $options = []): array
    {
        $search = new PickupPointsSearchModel(
            $shippingAddress->getStreet(),
            $shippingAddress->getPostcode(),
            $shippingAddress->getCity(),
            $shippingAddress->getCountryCode(),
            ((new \DateTime())->add(new \DateInterval('P2D')))->format('d/m/Y'),
        );

        if (array_key_exists('shippingDate', $options)) {
            $search->setShippingDate($options['shippingDate']);
        }

        return array_map(
            static fn (PickupPoint $pickupPoint) => $pickupPoint->getData(),
            $this->pickupPointsService->call($search, $options),
        );
    }
}
