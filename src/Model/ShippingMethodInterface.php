<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Model;

interface ShippingMethodInterface
{
    public function setColissimoPickup(bool $colissimoPickup): void;

    public function isColissimoPickup(): bool;

    public function setColissimoHomeDelivery(bool $colissimoHomeDelivery): void;

    public function isColissimoHomeDelivery(): bool;
}
