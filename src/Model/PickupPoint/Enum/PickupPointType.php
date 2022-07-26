<?php

namespace CleverAge\SyliusColissimoPlugin\Model\PickupPoint\Enum;

interface PickupPointType
{
    // Poste
    public const BPR = 'BPR';
    public const ACP = 'ACP';
    public const CDI = 'CDI';

    // Belgium poste
    public const BDP = 'BDP';

    // Pickup point
    public const A2P = 'A2P';
    public const CMT = 'CMT';

    // Consigne
    public const PCS = 'PCS';
}
