<?php

namespace CleverAge\SyliusColissimoPlugin\Model\PickupPoint\Enum;

use CleverAge\SyliusColissimoPlugin\Model\Shipping\Enum\ProductCode;

class PickupPointReseau
{
    public const R03 = 'R03';
    public const R12 = 'R12';
    public const X00 = 'X00';

    public const ALL = [
        self::R03, self::R12, self::X00,
    ];

    public const COUNTRY_CODE_R03 = [
        'DE', 'ES', 'GB', 'LU', 'NL',
    ];

    public const COUNTRY_CODE_R12 = [
        'BE',
    ];

    public const COUNTRY_CODE_X00 = [
        'DE', 'ES', 'NL',
    ];

    public static function getByCountryCodeAndProductCode(string $countryCode, ?string $productCode = null): string
    {
        if (null === $productCode) {
            if (in_array($countryCode, self::COUNTRY_CODE_R03)) {
                return self::R03;
            } elseif (in_array($countryCode, self::COUNTRY_CODE_R12)) {
                return self::R12;
            } elseif (in_array($countryCode, self::COUNTRY_CODE_X00)) {
                return self::X00;
            }

            return '';
        }

        if (in_array($countryCode, self::COUNTRY_CODE_R03) && $productCode === ProductCode::CMT) {
            return self::R03;
        } elseif (
            in_array($countryCode, self::COUNTRY_CODE_R12)
            && ($productCode === ProductCode::CMT || $productCode === ProductCode::BDP)
        ) {
            return self::R12;
        } elseif (
            in_array($countryCode, self::COUNTRY_CODE_X00)
            && ($productCode === ProductCode::CMT || $productCode === ProductCode::PCS)
        ) {
            return self::X00;
        }

        return '';
    }
}
