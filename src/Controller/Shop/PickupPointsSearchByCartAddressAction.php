<?php

namespace CleverAge\SyliusColissimoPlugin\Controller\Shop;

use CleverAge\SyliusColissimoPlugin\Controller\ActionInterface;
use CleverAge\SyliusColissimoPlugin\Service\SearchPickupPointService;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PickupPointsSearchByCartAddressAction implements ActionInterface
{
    public function __construct(
        private CartContextInterface $cartContext,
        private SearchPickupPointService $searchPickupPointService,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        if (!$shippingAddress = $order->getShippingAddress()) {
            throw new NotFoundHttpException('Empty shipping address');
        }

        if (
            null === $shippingAddress->getPostcode()
            || null === $shippingAddress->getCity()
            || null === $shippingAddress->getCountryCode()
        ) {
            throw new NotFoundHttpException('Address postcode, city and/or countryCode was null');
        }

        $pickupPoints = $this->searchPickupPointService->byCartAddress(
            $shippingAddress,
            (array) $request->get('options', []),
        );

        return new JsonResponse($pickupPoints);
    }
}
