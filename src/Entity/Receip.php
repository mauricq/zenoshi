<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Receip
 *
 * @ORM\Table(name="receip", indexes={@ORM\Index(name="FK_PERSON_UPLOAD_RECEIP", columns={"ID_PERSON_UPLOAD_RECEIP"}), @ORM\Index(name="FK_RECEIP_APPROBATION", columns={"ID_CATALOG"}), @ORM\Index(name="FK_RECEIP_MERCHANT", columns={"ID_MERCHANT"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReceipRepository")
 */
class Receip extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_RECEIP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReceip;

    /**
     * @var string
     *
     * @ORM\Column(name="MERCHANT_NAME", type="string", length=200, nullable=false)
     */
    private $merchantName;

    /**
     * @var string
     *
     * @ORM\Column(name="AMOUNT", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_EMISSION", type="datetime", nullable=false)
     */
    private $dateEmission;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_REGISTRATION", type="datetime", nullable=false)
     */
    private $dateRegistration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="INCENTIVE_POINTS", type="integer", nullable=true)
     */
    private $incentivePoints;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PERSON_UPLOAD_RECEIP", referencedColumnName="ID_PERSON")
     * })
     */
    private $idPersonUploadReceip;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATALOG", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idCatalog;

    /**
     * @var \Merchant
     *
     * @ORM\ManyToOne(targetEntity="Merchant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MERCHANT", referencedColumnName="ID_MERCHANT")
     * })
     */
    private $idMerchant;

    public function getIdReceip(): ?int
    {
        return $this->idReceip;
    }

    public function getMerchantName(): ?string
    {
        return $this->merchantName;
    }

    public function setMerchantName(string $merchantName): self
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->dateEmission;
    }

    public function setDateEmission(\DateTimeInterface $dateEmission): self
    {
        $this->dateEmission = $dateEmission;

        return $this;
    }

    public function getDateRegistration(): ?\DateTimeInterface
    {
        return $this->dateRegistration;
    }

    public function setDateRegistration(\DateTimeInterface $dateRegistration): self
    {
        $this->dateRegistration = $dateRegistration;

        return $this;
    }

    public function getIncentivePoints(): ?int
    {
        return $this->incentivePoints;
    }

    public function setIncentivePoints(?int $incentivePoints): self
    {
        $this->incentivePoints = $incentivePoints;

        return $this;
    }

    public function getIdPersonUploadReceip(): ?Person
    {
        return $this->idPersonUploadReceip;
    }

    public function setIdPersonUploadReceip(?Person $idPersonUploadReceip): self
    {
        $this->idPersonUploadReceip = $idPersonUploadReceip;

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

    public function getIdMerchant(): ?Merchant
    {
        return $this->idMerchant;
    }

    public function setIdMerchant(?Merchant $idMerchant): self
    {
        $this->idMerchant = $idMerchant;

        return $this;
    }


}
