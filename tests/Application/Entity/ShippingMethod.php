<?php

declare(strict_types=1);

namespace Tests\CleverAge\SyliusColissimoPlugin\Application\Entity;

use CleverAge\SyliusColissimoPlugin\Model\ShippingMethodInterface;
use CleverAge\SyliusColissimoPlugin\Model\ShippingMethodTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shipping_method")
 */
class ShippingMethod extends BaseShippingMethod implements ShippingMethodInterface
{
    use ShippingMethodTrait;
}
