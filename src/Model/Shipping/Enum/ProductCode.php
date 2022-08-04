<?php

namespace CleverAge\SyliusColissimoPlugin\Model\Shipping\Enum;

use CleverAge\SyliusColissimoPlugin\Model\BaseEnum;

class ProductCode extends BaseEnum
{
    // FRANCE
    public const DOM  = 'DOM';
    public const COLD = 'COLD';
    public const DOS  = 'DOS';
    public const COL  = 'COL';
    public const BPR  = 'BPR';
    public const A2P  = 'A2P';
    public const CORE = 'CORE';
    public const COLR = 'COLR';
    public const JP1  = 'J+1';

    // International
    public const CORI = 'CORI';
    public const COM  = 'COM';
    public const CDS  = 'CDS';
    public const ECO  = 'ECO';
    public const ACP  = 'ACP';
    public const COLI = 'COLI';
    public const ACCI = 'ACCI';
    public const CMT  = 'CMT';
    public const PCS  = 'PCS';
    public const BDP  = 'BDP';
    public const CDI  = 'CDI';
    public const BOS  = 'BOS';
    public const BOM  = 'BOM';

    public const ALL = [
        '6A'  => self::DOM,
        '9L'  => self::COLD,
        '6C'  => self::DOS,
        '9V'  => self::COL,
        '6H'  => self::BPR,
        '6M'  => self::A2P,
        '8R'  => self::CORE,
        '6G'  => self::COLR,
        '6V'  => self::JP1,
        '7R'  => self::CORI,
        '8Q'  => self::COM,
        '7Q'  => self::CDS,
        '9W'  => self::ECO,
        '5R'  => self::CORI,
        'CP'  => self::COLI,
        'EY'  => self::COLI,
        'EN'  => self::ACCI,
        'CM'  => self::CMT,
        'CG'  => 'PCG',
        'CA'  => self::DOM,
        'CB'  => self::DOS,
        'BDP' => 'CI',
    ];
}
