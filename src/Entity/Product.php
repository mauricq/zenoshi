<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="FK_MERCHANT_PRODUCT", columns={"ID_MERCHANT"}), @ORM\Index(name="FK_PHOTO_PRODUCT", columns={"ID_PHOTO_PRODUCT"}), @ORM\Index(name="FK_PRODUCT_STATUS", columns={"ID_CATALOG"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PRODUCT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=200, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DISCOUNT", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $discount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="POINTS", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var \Merchant
     *
     * @ORM\ManyToOne(targetEntity="Merchant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MERCHANT", referencedColumnName="ID_MERCHANT")
     * })
     */
    private $idMerchant;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PHOTO_PRODUCT", referencedColumnName="ID_FILE")
     * })
     */
    private $idPhotoProduct;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATALOG", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idCatalog;

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): self
    {
        $this->discount = $discount;

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

    public function getIdMerchant(): ?Merchant
    {
        return $this->idMerchant;
    }

    public function setIdMerchant(?Merchant $idMerchant): self
    {
        $this->idMerchant = $idMerchant;

        return $this;
    }

    public function getIdPhotoProduct(): ?File
    {
        return $this->idPhotoProduct;
    }

    public function setIdPhotoProduct(?File $idPhotoProduct): self
    {
        $this->idPhotoProduct = $idPhotoProduct;

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
