<?php

namespace CleverAge\SyliusColissimoPlugin\Model\PickupPoint;

class PickupPointsSearchModel
{
    private string $address;
    private string $zipCode;
    private string $city;
    private string $countryCode;
    private string $shippingDate;

    public function __construct(string $address, string $zipCode, string $city, string $countryCode, string $shippingDate)
    {
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->shippingDate = $shippingDate;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getShippingDate(): string
    {
        return $this->shippingDate;
    }

    public function setShippingDate(string $shippingDate): self
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }
}
