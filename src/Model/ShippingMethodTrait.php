<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait ShippingMethodTrait
{
    /**
     * @ORM\Column(type="boolean", name="colissimo_pickup", options={"default": "0"})
     */
    protected bool $colissimoPickup = false;

    /**
     * @ORM\Column(type="boolean", name="colissimo_home_delivery",  options={"default": "0"})
     */
    protected bool $colissimoHomeDelivery = false;

    public function setColissimoPickup(bool $colissimoPickup): void
    {
        $this->colissimoPickup = $colissimoPickup;
    }

    public function isColissimoPickup(): bool
    {
        return $this->colissimoPickup;
    }

    public function setColissimoHomeDelivery(bool $colissimoHomeDelivery): void
    {
        $this->colissimoHomeDelivery = $colissimoHomeDelivery;
    }

    public function isColissimoHomeDelivery(): bool
    {
        return $this->colissimoHomeDelivery;
    }
}
