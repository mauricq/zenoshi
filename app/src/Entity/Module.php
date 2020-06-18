<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="module", indexes={@ORM\Index(name="fk_module_status", columns={"id_module_status"}), @ORM\Index(name="fk_submodulo", columns={"id_submodule"})})
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_module", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idModule;

    /**
     * @var string
     *
     * @ORM\Column(name="module_code", type="string", length=50, nullable=false)
     */
    private $moduleCode;

    /**
     * @var string
     *
     * @ORM\Column(name="module_name", type="string", length=50, nullable=false)
     */
    private $moduleName;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_module_status", referencedColumnName="id_catalog")
     * })
     */
    private $idModuleStatus;

    /**
     * @var \Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_submodule", referencedColumnName="id_module")
     * })
     */
    private $idSubmodule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Profile", mappedBy="idModule")
     */
    private $idProfile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProfile = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdModule(): ?int
    {
        return $this->idModule;
    }

    public function getModuleCode(): ?string
    {
        return $this->moduleCode;
    }

    public function setModuleCode(string $moduleCode): self
    {
        $this->moduleCode = $moduleCode;

        return $this;
    }

    public function getModuleName(): ?string
    {
        return $this->moduleName;
    }

    public function setModuleName(string $moduleName): self
    {
        $this->moduleName = $moduleName;

        return $this;
    }

    public function getIdModuleStatus(): ?Catalogue
    {
        return $this->idModuleStatus;
    }

    public function setIdModuleStatus(?Catalogue $idModuleStatus): self
    {
        $this->idModuleStatus = $idModuleStatus;

        return $this;
    }

    public function getIdSubmodule(): ?self
    {
        return $this->idSubmodule;
    }

    public function setIdSubmodule(?self $idSubmodule): self
    {
        $this->idSubmodule = $idSubmodule;

        return $this;
    }

    /**
     * @return Collection|Profile[]
     */
    public function getIdProfile(): Collection
    {
        return $this->idProfile;
    }

    public function addIdProfile(Profile $idProfile): self
    {
        if (!$this->idProfile->contains($idProfile)) {
            $this->idProfile[] = $idProfile;
            $idProfile->addIdModule($this);
        }

        return $this;
    }

    public function removeIdProfile(Profile $idProfile): self
    {
        if ($this->idProfile->contains($idProfile)) {
            $this->idProfile->removeElement($idProfile);
            $idProfile->removeIdModule($this);
        }

        return $this;
    }

}
