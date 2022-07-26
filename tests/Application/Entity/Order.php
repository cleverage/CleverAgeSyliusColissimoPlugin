<?php

declare(strict_types=1);

namespace Tests\CleverAge\SyliusColissimoPlugin\Application\Entity;

use CleverAge\SyliusColissimoPlugin\Model\OrderInterface;
use CleverAge\SyliusColissimoPlugin\Model\OrderTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order")
 */
class Order extends BaseOrder implements OrderInterface
{
    use OrderTrait;
}
