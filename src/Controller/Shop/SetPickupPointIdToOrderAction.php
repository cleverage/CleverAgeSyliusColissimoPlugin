<?php

namespace CleverAge\SyliusColissimoPlugin\Controller\Shop;

use CleverAge\SyliusColissimoPlugin\Controller\ActionInterface;
use CleverAge\SyliusColissimoPlugin\Model\OrderInterface;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\Enum\PickupPointReseau;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPointSearchByIdModel;
use CleverAge\SyliusColissimoPlugin\Service\PickupPointByIdService;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SetPickupPointIdToOrderAction implements ActionInterface
{

    public function __construct(
        private CartContextInterface $cartContext,
        private EntityManagerInterface $entityManager,
        private PickupPointByIdService $pickupPointByIdService
    ) {
    }

    public function __invoke(Request $request): Response
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        if ($order->isEmpty()) {
            throw new NotFoundHttpException('Order was empty');
        }

        if (!$pickupPointId = $request->request->get('pickupPointId')) {
            throw new NotFoundHttpException('pickupPointId param not found.');
        }

        $pickupPointId = (string) $pickupPointId;

        $search = new PickupPointSearchByIdModel(
            $pickupPointId,
            ((new \DateTime())->add(new \DateInterval('P2D')))->format('d/m/Y'),
        );

        $options = [];
        $countryCode = $order->getShippingAddress()->getCountryCode();
        if ($countryCode !== 'FR') {
            $options['reseau'] = PickupPointReseau::getByCountryCodeAndProductCode($countryCode);
        }

        $pickupPoint = $this->pickupPointByIdService->call($search, $options);
        if (null === $pickupPoint) {
            throw new NotFoundHttpException("Pickup point not found for id '$pickupPointId'");
        }

        $order->setPickupPointId($pickupPointId);
        $this->entityManager->flush();

        return new JsonResponse($pickupPoint->getData());
    }
}
