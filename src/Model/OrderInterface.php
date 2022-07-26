<?php

namespace CleverAge\SyliusColissimoPlugin\Model;

interface OrderInterface
{
    public function setPickupPointId(?string $pickupPointId): void;

    public function getPickupPointId(): ?string;
}
