<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="fk_merchant_product", columns={"id_merchant"}), @ORM\Index(name="fk_photo_product", columns={"id_photo_product"}), @ORM\Index(name="fk_product_status", columns={"id_product_status"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_product", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="discount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $discount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var \Merchant
     *
     * @ORM\ManyToOne(targetEntity="Merchant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_merchant", referencedColumnName="id_merchant")
     * })
     */
    private $idMerchant;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_photo_product", referencedColumnName="id_file")
     * })
     */
    private $idPhotoProduct;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product_status", referencedColumnName="id_catalog")
     * })
     */
    private $idProductStatus;

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

    public function getIdProductStatus(): ?Catalogue
    {
        return $this->idProductStatus;
    }

    public function setIdProductStatus(?Catalogue $idProductStatus): self
    {
        $this->idProductStatus = $idProductStatus;

        return $this;
    }


}
