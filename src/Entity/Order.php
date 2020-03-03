<?php declare(strict_types=1);

namespace App\Entity;

class Order
{
    const SHIPPING_PROVIDER_UPS = 'ups';
    const SHIPPING_PROVIDER_OMNIVA = 'omniva';
    const SHIPPING_PROVIDER_DHL = 'dhl';

    /** @var string */
    private $id;

    /** @var string */
    private $street;

    /** @var string */
    private $postCode;

    /** @var string */
    private $city;

    /** @var string */
    private $country;

    /** @var string */
    private $shippingName;

    /**
     * Order constructor.
     *
     * @param string $id
     * @param string $street
     * @param string $postCode
     * @param string $city
     * @param string $country
     * @param string $shippingName
     */
    public function __construct(
        string $id,
        string $street,
        string $postCode,
        string $city,
        string $country,
        string $shippingName = self::SHIPPING_PROVIDER_UPS
    ) {
        $this->id           = $id;
        $this->street       = $street;
        $this->postCode     = $postCode;
        $this->city         = $city;
        $this->country      = $country;
        $this->shippingName = $shippingName;
    }

    /**
     * @return string
     */
    public function getShipping(): string
    {
        return $this->shippingName;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}