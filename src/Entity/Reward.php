<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Reward
 *
 * @ORM\Table(name="reward", indexes={@ORM\Index(name="fk_file_reward", columns={"id_file_reward"}), @ORM\Index(name="fk_merchant_reward", columns={"id_merchant"}), @ORM\Index(name="fk_person_registration_reward", columns={"id_person_registration_reward"}), @ORM\Index(name="fk_reward_status", columns={"id_reward_status"})})
 * @ORM\Entity(repositoryClass="App\Repository\RewardRepository")
 */
class Reward extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reward", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"reward"})
     */
    private $idReward;

    /**
     * @var string
     *
     * @ORM\Column(name="name_reward", type="string", length=100, nullable=false)
     * @Groups({"reward"})
     */
    private $nameReward;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_reward", type="string", length=999, nullable=true)
     * @Groups({"reward"})
     */
    private $descriptionReward;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rule_reward", type="string", length=9999, nullable=true)
     * @Groups({"reward"})
     */
    private $ruleReward;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     * @Groups({"reward"})
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="shipping", type="integer", nullable=true)
     * @Groups({"reward"})
     */
    private $shipping;

    /**
     * @var int|null
     *
     * @ORM\Column(name="discount_price", type="integer", nullable=true)
     * @Groups({"reward"})
     */
    private $discountPrice;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_file_reward", referencedColumnName="id_file")
     * })
     * @Groups({"reward"})
     */
    private $idFileReward;

    /**
     * @var \Merchant
     *
     * @ORM\ManyToOne(targetEntity="Merchant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_merchant", referencedColumnName="id_merchant")
     * })
     * @Groups({"reward"})
     */
    private $idMerchant;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_person_registration_reward", referencedColumnName="id_person")
     * })
     * @Groups({"reward"})
     */
    private $idPersonRegistrationReward;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reward_status", referencedColumnName="id_catalog")
     * })
     * @Groups({"reward"})
     */
    private $idRewardStatus;

    public function getIdReward(): ?int
    {
        return $this->idReward;
    }

    public function getNameReward(): ?string
    {
        return $this->nameReward;
    }

    public function setNameReward(string $nameReward): self
    {
        $this->nameReward = $nameReward;

        return $this;
    }

    public function getDescriptionReward(): ?string
    {
        return $this->descriptionReward;
    }

    public function setDescriptionReward(?string $descriptionReward): self
    {
        $this->descriptionReward = $descriptionReward;

        return $this;
    }

    public function getRuleReward(): ?string
    {
        return $this->ruleReward;
    }

    public function setRuleReward(?string $ruleReward): self
    {
        $this->ruleReward = $ruleReward;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getShipping(): ?int
    {
        return $this->shipping;
    }

    public function setShipping(?int $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getDiscountPrice(): ?int
    {
        return $this->discountPrice;
    }

    public function setDiscountPrice(?int $discountPrice): self
    {
        $this->discountPrice = $discountPrice;

        return $this;
    }

    public function getIdFileReward(): ?File
    {
        return $this->idFileReward;
    }

    public function setIdFileReward(?File $idFileReward): self
    {
        $this->idFileReward = $idFileReward;

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

    public function getIdPersonRegistrationReward(): ?Person
    {
        return $this->idPersonRegistrationReward;
    }

    public function setIdPersonRegistrationReward(?Person $idPersonRegistrationReward): self
    {
        $this->idPersonRegistrationReward = $idPersonRegistrationReward;

        return $this;
    }

    public function getIdRewardStatus(): ?Catalogue
    {
        return $this->idRewardStatus;
    }

    public function setIdRewardStatus(?Catalogue $idRewardStatus): self
    {
        $this->idRewardStatus = $idRewardStatus;

        return $this;
    }

    /**
     * @param int $idReward
     */
    public function setIdReward(int $idReward): void
    {
        $this->idReward = $idReward;
    }


}
