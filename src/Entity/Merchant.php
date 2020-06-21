<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Merchant
 *
 * @ORM\Table(name="merchant", indexes={@ORM\Index(name="fk_merchant_category", columns={"id_merchant_category"}), @ORM\Index(name="fk_merchant_owner_person", columns={"id_person"}), @ORM\Index(name="fk_merchant_status", columns={"id_merchant_status"}), @ORM\Index(name="fk_merchant_status_approval", columns={"id_merchant_status_approval"})})
 * @ORM\Entity(repositoryClass="App\Repository\MerchantRepository")
 */
class Merchant extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_merchant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMerchant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="merchant_name", type="string", length=200, nullable=true)
     */
    private $merchantName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=200, nullable=true)
     */
    private $address;

    /**
     * @var int|null
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

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
     * @ORM\Column(name="website", type="string", length=999, nullable=true)
     */
    private $website;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="approval_date", type="datetime", nullable=true)
     */
    private $approvalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime", nullable=false)
     */
    private $registrationDate;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_merchant_category", referencedColumnName="id_catalog")
     * })
     */
    private $idMerchantCategory;

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
     *   @ORM\JoinColumn(name="id_merchant_status", referencedColumnName="id_catalog")
     * })
     */
    private $idMerchantStatus;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_merchant_status_approval", referencedColumnName="id_catalog")
     * })
     */
    private $idMerchantStatusApproval;

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

    public function getIdMerchantStatus(): ?Catalogue
    {
        return $this->idMerchantStatus;
    }

    public function setIdMerchantStatus(?Catalogue $idMerchantStatus): self
    {
        $this->idMerchantStatus = $idMerchantStatus;

        return $this;
    }

    public function getIdMerchantStatusApproval(): ?Catalogue
    {
        return $this->idMerchantStatusApproval;
    }

    public function setIdMerchantStatusApproval(?Catalogue $idMerchantStatusApproval): self
    {
        $this->idMerchantStatusApproval = $idMerchantStatusApproval;

        return $this;
    }

    /**
     * @param int $idMerchant
     */
    public function setId(int $idMerchant): void
    {
        $this->idMerchant = $idMerchant;
    }

}
