<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reward
 *
 * @ORM\Table(name="reward", indexes={@ORM\Index(name="FK_REWARD_STATUS", columns={"ID_CATALOG"})})
 * @ORM\Entity(repositoryClass="App\Repository\RewardRepository")
 */
class Reward extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_REWARD", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReward;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME_REWARD", type="string", length=100, nullable=false)
     */
    private $nameReward;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION_REWARD", type="string", length=999, nullable=true)
     */
    private $descriptionReward;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RULE_REWARD", type="string", length=9999, nullable=true)
     */
    private $ruleReward;

    /**
     * @var int|null
     *
     * @ORM\Column(name="INCENTIVE_POINTS", type="integer", nullable=true)
     */
    private $incentivePoints;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATALOG", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idCatalog;

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

    public function getIncentivePoints(): ?int
    {
        return $this->incentivePoints;
    }

    public function setIncentivePoints(?int $incentivePoints): self
    {
        $this->incentivePoints = $incentivePoints;

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
