<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="account", indexes={@ORM\Index(name="FK_PERSON_ACCOUNT", columns={"ID_PERSON"})})
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_ACCOUNT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAccount;

    /**
     * @var string
     *
     * @ORM\Column(name="ACCOUNT_NUMBER", type="string", length=20, nullable=false)
     */
    private $accountNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="TOTAL_INCENTIVE_POINTS", type="integer", nullable=true)
     */
    private $totalIncentivePoints;

    /**
     * @var int|null
     *
     * @ORM\Column(name="REWARD_COINS", type="integer", nullable=true)
     */
    private $rewardCoins;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="LAST_UPDATE", type="datetime", nullable=true)
     */
    private $lastUpdate;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PERSON", referencedColumnName="ID_PERSON")
     * })
     */
    private $idPerson;

    public function getIdAccount(): ?int
    {
        return $this->idAccount;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getTotalIncentivePoints(): ?int
    {
        return $this->totalIncentivePoints;
    }

    public function setTotalIncentivePoints(?int $totalIncentivePoints): self
    {
        $this->totalIncentivePoints = $totalIncentivePoints;

        return $this;
    }

    public function getRewardCoins(): ?int
    {
        return $this->rewardCoins;
    }

    public function setRewardCoins(?int $rewardCoins): self
    {
        $this->rewardCoins = $rewardCoins;

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(?\DateTimeInterface $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

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


}
