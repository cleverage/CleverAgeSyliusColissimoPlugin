<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ColissimoParameterInterface extends ResourceInterface
{
    public function setId(int $id): self;

    public function getId(): ?int;

    public function isTestModeEnabled(): bool;

    public function setTestModeEnabled(bool $testModeEnabled): self;

    public function getContractNumber(): string;

    public function setContractNumber(string $contractNumber): self;

    public function getPassword(): string;

    public function setPassword(string $password): self;

    public function getCommercialName(): string;

    public function setCommercialName(string $commercialName): self;

    public function getCompanyName(): string;

    public function setCompanyName(string $companyName): self;

    public function getLine0(): ?string;

    public function setLine0(?string $line0): self;

    public function getLine1(): ?string;

    public function setLine1(?string $line1): self;

    public function getLine2(): string;

    public function setLine2(string $line2): self;

    public function getLine3(): ?string;

    public function setLine3(?string $line3): self;

    public function getCountryCode(): string;

    public function setCountryCode(string $countryCode): self;

    public function getZipCode(): string;

    public function setZipCode(string $zipCode): self;

    public function getCity(): string;

    public function setCity(string $city): self;
}
