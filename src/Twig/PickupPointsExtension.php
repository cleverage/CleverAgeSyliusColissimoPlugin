<?php

namespace CleverAge\SyliusColissimoPlugin\Twig;

use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\Enum\PickupPointType;
use CleverAge\SyliusColissimoPlugin\Model\PickupPoint\PickupPoint;
use CleverAge\SyliusColissimoPlugin\Service\SearchPickupPointService;
use Nette\Utils\Json;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class PickupPointsExtension extends AbstractExtension
{
    private CartContextInterface $cartContext;
    private SearchPickupPointService $searchPickupPointService;
    private TranslatorInterface $translator;

    public function __construct(
        CartContextInterface $cartContext,
        SearchPickupPointService $searchPickupPointService,
        TranslatorInterface $translator
    ) {
        $this->cartContext = $cartContext;
        $this->searchPickupPointService = $searchPickupPointService;
        $this->translator = $translator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('clever_age_colissimo_get_pickup_points', [$this, 'getPickupPoints']),
            new TwigFunction('clever_age_colissimo_get_pickup_by_id', [$this, 'getPickupPointById']),
            new TwigFunction('clever_age_colissimo_get_pickup_type_name', [$this, 'getTypeName']),
        ];
    }

    public function getPickupPointById(string $pickupPointId): ?PickupPoint
    {
        return $this->searchPickupPointService->byId($pickupPointId);
    }

    /**
     * @return array|array<PickupPoint>
     */
    public function getPickupPoints(): array
    {
        /** @var OrderInterface $order */
        $order = $this->cartContext->getCart();
        $shippingAddress = $order->getShippingAddress();
        if ($order->isEmpty() || null === $shippingAddress) {
            return [];
        }

        return $this->searchPickupPointService->byCartAddress($shippingAddress);
    }

    public function getTypeName(string $type): string
    {
        switch ($type) {
            case PickupPointType::A2P:
            case PickupPointType::PCS:
                return $this->translator->trans('clever_age.ui.pickup_point.trader');
            case PickupPointType::BPR:
            case PickupPointType::BDP:
            case PickupPointType::CDI:
            case PickupPointType::ACP:
                return $this->translator->trans('clever_age.ui.pickup_point.post_office');
            default:
                return '';
        }
    }
}
