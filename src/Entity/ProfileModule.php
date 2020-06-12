<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfileModule
 *
 * @ORM\Table(name="profile_module", indexes={@ORM\Index(name="FK_PROFILE_MODULE", columns={"ID_PROFILE"}), @ORM\Index(name="FK_PROFILE_MODULE2", columns={"ID_MODULE"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProfileModuleRepository")
 */
class ProfileModule extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PROFILE_MODULE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfileModule;

    /**
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PROFILE", referencedColumnName="ID_PROFILE")
     * })
     */
    private $idProfile;

    /**
     * @var \Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MODULE", referencedColumnName="ID_MODULE")
     * })
     */
    private $idModule;

    public function getIdProfileModule(): ?int
    {
        return $this->idProfileModule;
    }

    public function getIdProfile(): ?Profile
    {
        return $this->idProfile;
    }

    public function setIdProfile(?Profile $idProfile): self
    {
        $this->idProfile = $idProfile;

        return $this;
    }

    public function getIdModule(): ?Module
    {
        return $this->idModule;
    }

    public function setIdModule(?Module $idModule): self
    {
        $this->idModule = $idModule;

        return $this;
    }


}
