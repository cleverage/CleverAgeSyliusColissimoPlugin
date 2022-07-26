<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CleverAge\SyliusColissimoPlugin\Repository\ColissimoParameterRepository")
 * @ORM\Table("cleverage_colissimo_parameter")
 */
class ColissimoParameter implements ColissimoParameterInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="boolean", options={"default": "0"})
     */
    private bool $testModeEnabled = false;

    /**
     * @ORM\Column(type="string")
     */
    private string $contractNumber = '';

    /**
     * @ORM\Column(type="string")
     */
    private string $password = '';

    /**
     * @ORM\Column(type="string")
     */
    private string $commercialName = '';

    /**
     * @ORM\Column(type="string")
     */
    private string $companyName = '';

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $line0 = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $line1 = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $line2 = '';

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $line3 = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $countryCode = 'FR';

    /**
     * @ORM\Column(type="string")
     */
    private string $zipCode = '';

    /**
     * @ORM\Column(type="string")
     */
    private string $city = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ColissimoParameterInterface
    {
        $this->id = $id;

        return $this;
    }

    public function isTestModeEnabled(): bool
    {
        return $this->testModeEnabled;
    }

    public function setTestModeEnabled(bool $testModeEnabled): self
    {
        $this->testModeEnabled = $testModeEnabled;

        return $this;
    }

    public function getContractNumber(): string
    {
        return $this->contractNumber;
    }

    public function setContractNumber(string $contractNumber): ColissimoParameter
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): ColissimoParameter
    {
        $this->password = $password;

        return $this;
    }

    public function getCommercialName(): string
    {
        return $this->commercialName;
    }

    public function setCommercialName(string $commercialName): ColissimoParameter
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): ColissimoParameter
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getLine0(): ?string
    {
        return $this->line0;
    }

    public function setLine0(?string $line0): ColissimoParameter
    {
        $this->line0 = $line0;

        return $this;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(?string $line1): ColissimoParameter
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): string
    {
        return $this->line2;
    }

    public function setLine2(string $line2): ColissimoParameter
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getLine3(): ?string
    {
        return $this->line3;
    }

    public function setLine3(?string $line3): ColissimoParameter
    {
        $this->line3 = $line3;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): ColissimoParameter
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): ColissimoParameter
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): ColissimoParameter
    {
        $this->city = $city;

        return $this;
    }
}
