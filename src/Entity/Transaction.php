<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction", indexes={@ORM\Index(name="FK_ACCOUNT_TRANSACTION", columns={"ID_ACCOUNT"}), @ORM\Index(name="FK_TRANSACTION_TYPE", columns={"ID_TRANSACTION_TYPE"})})
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TRANSACTION", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTransaction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_TRANSACTION", type="datetime", nullable=false)
     */
    private $dateTransaction;

    /**
     * @var int
     *
     * @ORM\Column(name="POINTS", type="integer", nullable=false)
     */
    private $points;

    /**
     * @var string
     *
     * @ORM\Column(name="DEBIT_CREDIT", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $debitCredit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=200, nullable=true)
     */
    private $description;

    /**
     * @var \Account
     *
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ACCOUNT", referencedColumnName="ID_ACCOUNT")
     * })
     */
    private $idAccount;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_TRANSACTION_TYPE", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idTransactionType;

    public function getIdTransaction(): ?int
    {
        return $this->idTransaction;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(\DateTimeInterface $dateTransaction): self
    {
        $this->dateTransaction = $dateTransaction;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getDebitCredit(): ?string
    {
        return $this->debitCredit;
    }

    public function setDebitCredit(string $debitCredit): self
    {
        $this->debitCredit = $debitCredit;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdAccount(): ?Account
    {
        return $this->idAccount;
    }

    public function setIdAccount(?Account $idAccount): self
    {
        $this->idAccount = $idAccount;

        return $this;
    }

    public function getIdTransactionType(): ?Catalogue
    {
        return $this->idTransactionType;
    }

    public function setIdTransactionType(?Catalogue $idTransactionType): self
    {
        $this->idTransactionType = $idTransactionType;

        return $this;
    }


}
