<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Receip
 *
 * @ORM\Table(name="receip", indexes={@ORM\Index(name="fk_person_upload_receip", columns={"id_person_upload_receip"}), @ORM\Index(name="fk_receip_approbation", columns={"id_receip_approbation"}), @ORM\Index(name="fk_receip_merchant", columns={"id_merchant"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReceipRepository")
 */
class Receip extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_receip", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"receip"})
     */
    private $idReceip;

    /**
     * @var string
     *
     * @ORM\Column(name="merchant_name", type="string", length=200, nullable=false)
     *
     * @Groups({"receip"})
     */
    private $merchantName;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=0, nullable=false)
     *
     * @Groups({"receip"})
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime(format="Y-m-d H:i:s", message="Incorrect DateTime format. Please use: 'Y-m-d H:i:s'")
     * @SerializedName("date_emission")
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @ORM\Column(name="date_emission", type="datetime", nullable=false)
     *
     * @Groups({"receip"})
     */
    private $dateEmission;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="date_registration", type="datetime", nullable=false)
     *
     * @Groups({"receip"})
     */
    private $dateRegistration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="incentive_points", type="integer", nullable=true)
     *
     * @Groups({"receip"})
     */
    private $incentivePoints;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_person_upload_receip", referencedColumnName="id_person")
     * })
     */
    private $idPersonUploadReceip;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_receip_approbation", referencedColumnName="id_catalog")
     * })
     */
    private $idReceipApprobation;

    /**
     * @var \Merchant
     *
     * @ORM\ManyToOne(targetEntity="Merchant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_merchant", referencedColumnName="id_merchant")
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

    public function getIdReceipApprobation(): ?Catalogue
    {
        return $this->idReceipApprobation;
    }

    public function setIdReceipApprobation(?Catalogue $idReceipApprobation): self
    {
        $this->idReceipApprobation = $idReceipApprobation;

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
