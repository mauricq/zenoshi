<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reward
 *
 * @ORM\Table(name="reward", indexes={@ORM\Index(name="fk_reward_status", columns={"id_reward_status"})})
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
     */
    private $idReward;

    /**
     * @var string
     *
     * @ORM\Column(name="name_reward", type="string", length=100, nullable=false)
     */
    private $nameReward;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_reward", type="string", length=999, nullable=true)
     */
    private $descriptionReward;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rule_reward", type="string", length=9999, nullable=true)
     */
    private $ruleReward;

    /**
     * @var int|null
     *
     * @ORM\Column(name="incentive_points", type="integer", nullable=true)
     */
    private $incentivePoints;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reward_status", referencedColumnName="id_catalog")
     * })
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

    public function getIncentivePoints(): ?int
    {
        return $this->incentivePoints;
    }

    public function setIncentivePoints(?int $incentivePoints): self
    {
        $this->incentivePoints = $incentivePoints;

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


}
