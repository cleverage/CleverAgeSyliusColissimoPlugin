<?php

namespace CleverAge\SyliusColissimoPlugin\Model\Shipping\Letter;

class Parcel
{
    /** @var int|float */
    private $weight;
    private ?string $pickupLocationId = null;

    /**
     * @return float|int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int|float $weight
     */
    public function setWeight($weight): Parcel
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPickupLocationId(): ?string
    {
        return $this->pickupLocationId;
    }

    public function setPickupLocationId(?string $pickupLocationId): Parcel
    {
        $this->pickupLocationId = $pickupLocationId;

        return $this;
    }

    public function toArray(): array
    {
        $base = ['weight' => $this->getWeight()];
        if ($pickupLocationId = $this->getPickupLocationId()) {
            $base['pickupLocationId'] = $pickupLocationId;
        }

        return $base;
    }
}
