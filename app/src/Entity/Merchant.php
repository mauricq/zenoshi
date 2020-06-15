<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Merchant
 *
 * @ORM\Table(name="merchant", indexes={@ORM\Index(name="FK_MERCHANT_CATEGORY", columns={"ID_MERCHANT_CATEGORY"}), @ORM\Index(name="FK_MERCHANT_OWNER_PERSON", columns={"ID_PERSON"}), @ORM\Index(name="FK_STATUS_APPROVAL", columns={"CAT_ID_CATALOG2"}), @ORM\Index(name="FK_STATUS_MERCHANT", columns={"ID_CATALOG"})})
 * @ORM\Entity(repositoryClass="App\Repository\MerchantRepository")
 */
class Merchant extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_MERCHANT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMerchant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="MERCHANT_NAME", type="string", length=200, nullable=true)
     */
    private $merchantName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ADDRESS", type="string", length=200, nullable=true)
     */
    private $address;

    /**
     * @var int|null
     *
     * @ORM\Column(name="POINTS", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CITY", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COUNTRY", type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="WEBSITE", type="string", length=999, nullable=true)
     */
    private $website;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="APPROVAL_DATE", type="datetime", nullable=true)
     */
    private $approvalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="REGISTRATION_DATE", type="datetime", nullable=false)
     */
    private $registrationDate;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MERCHANT_CATEGORY", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idMerchantCategory;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PERSON", referencedColumnName="ID_PERSON")
     * })
     */
    private $idPerson;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CAT_ID_CATALOG2", referencedColumnName="ID_CATALOG")
     * })
     */
    private $catIdCatalog2;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATALOG", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idCatalog;

    public function getIdMerchant(): ?int
    {
        return $this->idMerchant;
    }

    public function getMerchantName(): ?string
    {
        return $this->merchantName;
    }

    public function setMerchantName(?string $merchantName): self
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getApprovalDate(): ?\DateTimeInterface
    {
        return $this->approvalDate;
    }

    public function setApprovalDate(?\DateTimeInterface $approvalDate): self
    {
        $this->approvalDate = $approvalDate;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getIdMerchantCategory(): ?Catalogue
    {
        return $this->idMerchantCategory;
    }

    public function setIdMerchantCategory(?Catalogue $idMerchantCategory): self
    {
        $this->idMerchantCategory = $idMerchantCategory;

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

    public function getCatIdCatalog2(): ?Catalogue
    {
        return $this->catIdCatalog2;
    }

    public function setCatIdCatalog2(?Catalogue $catIdCatalog2): self
    {
        $this->catIdCatalog2 = $catIdCatalog2;

        return $this;
    }

    public function getIdCatalog(): ?Catalogue
    {
        return $this->idCatalog;
    }

    public function setIdCatalog(?Catalogue $idCatalog): self
    {
        $this->idCatalog = $idCatalog;

        return $this;
    }


}
