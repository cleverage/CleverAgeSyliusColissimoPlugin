<?php

namespace CleverAge\SyliusColissimoPlugin\Controller\Shop;

use CleverAge\SyliusColissimoPlugin\Controller\ActionInterface;
use CleverAge\SyliusColissimoPlugin\Model\OrderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class RemovePickupPointIdToOrderAction implements ActionInterface
{
    public function __construct(
        private CartContextInterface $cartContext,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if (!$pickupPointId = $request->get('pickupPointId')) {
            throw new NotFoundHttpException('pickupPointId param not found.');
        }

        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        $storedPickupPointId = $order->getPickupPointId();

        if ($storedPickupPointId === $pickupPointId) {
            $order->setPickupPointId(null);
            $this->entityManager->flush();
        }

        return new JsonResponse(['success' => true]);
    }
}
