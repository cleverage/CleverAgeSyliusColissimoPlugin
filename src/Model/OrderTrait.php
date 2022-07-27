<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait OrderTrait
{
    /**
     * @ORM\Column(type="string", name="pickup_point_id", nullable=true)
     */
    protected ?string $pickupPointId = null;

    public function setPickupPointId(?string $pickupPointId): void
    {
        $this->pickupPointId = $pickupPointId;
    }

    public function getPickupPointId(): ?string
    {
        return $this->pickupPointId;
    }
}
