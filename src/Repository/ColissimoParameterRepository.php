<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Repository;

use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameter;
use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameterInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ColissimoParameterRepository extends ServiceEntityRepository implements ColissimoParameterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ColissimoParameter::class);
    }

    public function get(): ?ColissimoParameterInterface
    {
        /** @var ?ColissimoParameterInterface $params */
        $params = $this->findOneBy([], ['id' => 'DESC']); // Get the last configuration in database.

        return $params;
    }
}
