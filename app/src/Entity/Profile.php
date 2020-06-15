<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profile", indexes={@ORM\Index(name="FK_PROFILE_STATUS", columns={"ID_CATALOG"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PROFILE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfile;

    /**
     * @var string
     *
     * @ORM\Column(name="PROFILE_CODE", type="string", length=50, nullable=false)
     */
    private $profileCode;

    /**
     * @var string
     *
     * @ORM\Column(name="PROFILE_NAME", type="string", length=50, nullable=false)
     */
    private $profileName;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATALOG", referencedColumnName="ID_CATALOG")
     * })
     */
    private $idCatalog;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Module", inversedBy="idProfile")
     * @ORM\JoinTable(name="profile_module",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_PROFILE", referencedColumnName="ID_PROFILE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_MODULE", referencedColumnName="ID_MODULE")
     *   }
     * )
     */
    private $idModule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="idProfile")
     */
    private $idUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idModule = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdProfile(): ?int
    {
        return $this->idProfile;
    }

    public function getProfileCode(): ?string
    {
        return $this->profileCode;
    }

    public function setProfileCode(string $profileCode): self
    {
        $this->profileCode = $profileCode;

        return $this;
    }

    public function getProfileName(): ?string
    {
        return $this->profileName;
    }

    public function setProfileName(string $profileName): self
    {
        $this->profileName = $profileName;

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

    /**
     * @return Collection|Module[]
     */
    public function getIdModule(): Collection
    {
        return $this->idModule;
    }

    public function addIdModule(Module $idModule): self
    {
        if (!$this->idModule->contains($idModule)) {
            $this->idModule[] = $idModule;
        }

        return $this;
    }

    public function removeIdModule(Module $idModule): self
    {
        if ($this->idModule->contains($idModule)) {
            $this->idModule->removeElement($idModule);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
            $idUser->addIdProfile($this);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        if ($this->idUser->contains($idUser)) {
            $this->idUser->removeElement($idUser);
            $idUser->removeIdProfile($this);
        }

        return $this;
    }

}
