<?php

namespace CleverAge\SyliusColissimoPlugin\EventSubscriber;

use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameterInterface;
use CleverAge\SyliusColissimoPlugin\Event\ColissimoParameterCredentialsHasherEvent;
use CleverAge\SyliusColissimoPlugin\Hasher\HasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

final class ColissimoParameterCredentialsHasherSubscriber implements EventSubscriberInterface
{
    private string $encryptionKey;
    private HasherInterface $hasher;
    private EntityManagerInterface $entityManager;

    public function __construct(
        string $encryptionKey,
        HasherInterface $hasher,
        EntityManagerInterface $entityManager
    ) {
        $this->encryptionKey = $encryptionKey;
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ColissimoParameterCredentialsHasherEvent::class => 'hashCredentials',
        ];
    }

    public function hashCredentials(GenericEvent $event): void
    {
        $entity = $event->getSubject();
        if (!$entity instanceof ColissimoParameterInterface) {
            return;
        }

        $entity->setContractNumber(
            $this->hasher->hash($entity->getContractNumber(), $this->encryptionKey),
        );

        $entity->setPassword(
            $this->hasher->hash($entity->getPassword(), $this->encryptionKey),
        );

        if (null === $entity->getId()) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }
}
