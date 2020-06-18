<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pincode
 *
 * @ORM\Table(name="pincode", indexes={@ORM\Index(name="fk_person_pincodes", columns={"id_person"}), @ORM\Index(name="fk_pin_status", columns={"id_pin_status"})})
 * @ORM\Entity(repositoryClass="App\Repository\PincodeRepository")
 */
class Pincode extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pincode", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPincode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plastic_brand", type="string", length=25, nullable=true)
     */
    private $plasticBrand;

    /**
     * @var string
     *
     * @ORM\Column(name="name_displayed", type="string", length=200, nullable=false)
     */
    private $nameDisplayed;

    /**
     * @var string
     *
     * @ORM\Column(name="pin_code", type="string", length=16, nullable=false)
     */
    private $pinCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=true)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="continent", type="string", length=20, nullable=true)
     */
    private $continent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="expiration_date", type="string", length=5, nullable=true)
     */
    private $expirationDate;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_person", referencedColumnName="id_person")
     * })
     */
    private $idPerson;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pin_status", referencedColumnName="id_catalog")
     * })
     */
    private $idPinStatus;

    public function getIdPincode(): ?int
    {
        return $this->idPincode;
    }

    public function getPlasticBrand(): ?string
    {
        return $this->plasticBrand;
    }

    public function setPlasticBrand(?string $plasticBrand): self
    {
        $this->plasticBrand = $plasticBrand;

        return $this;
    }

    public function getNameDisplayed(): ?string
    {
        return $this->nameDisplayed;
    }

    public function setNameDisplayed(string $nameDisplayed): self
    {
        $this->nameDisplayed = $nameDisplayed;

        return $this;
    }

    public function getPinCode(): ?string
    {
        return $this->pinCode;
    }

    public function setPinCode(string $pinCode): self
    {
        $this->pinCode = $pinCode;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(?string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    public function getExpirationDate(): ?string
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?string $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getIdPerson(): ?Person
    {
        return $this->idPerson;
    }

    public function setIdPerson(?Person $idPerson): self
    {
        $this->idPerson = $idPerson;

        return $this;
    }

    public function getIdPinStatus(): ?Catalogue
    {
        return $this->idPinStatus;
    }

    public function setIdPinStatus(?Catalogue $idPinStatus): self
    {
        $this->idPinStatus = $idPinStatus;

        return $this;
    }


}
