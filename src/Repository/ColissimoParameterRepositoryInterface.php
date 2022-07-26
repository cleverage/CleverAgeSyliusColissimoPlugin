<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Repository;

use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameterInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @method ColissimoParameterInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ColissimoParameterInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method ColissimoParameterInterface[]    findAll()
 * @method ColissimoParameterInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ColissimoParameterRepositoryInterface
{
    public function get(): ?ColissimoParameterInterface;
}
