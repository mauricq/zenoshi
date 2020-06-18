<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalogue
 *
 * @ORM\Table(name="catalogue", indexes={@ORM\Index(name="FK_PARENT", columns={"ID_PARENT"})})
 * @ORM\Entity(repositoryClass="App\Repository\CatalogueRepository")
 */
class Catalogue extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CATALOG", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCatalog;

    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", length=10, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=100, nullable=false)
     */
    private $type;

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
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PARENT", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idParent;

    public function getIdCatalog(): ?int
    {
        return $this->idCatalog;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getIdParent(): ?self
    {
        return $this->idParent;
    }

    public function setIdParent(?self $idParent): self
    {
        $this->idParent = $idParent;

        return $this;
    }

    /**
     * @param int $idCatalog
     */
    public function setIdCatalog(int $idCatalog): void
    {
        $this->idCatalog = $idCatalog;
    }
}
