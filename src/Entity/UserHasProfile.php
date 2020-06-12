<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserHasProfile
 *
 * @ORM\Table(name="user_has_profile", indexes={@ORM\Index(name="FK_USER_HAS_PROFILE", columns={"ID_USER"}), @ORM\Index(name="FK_USER_HAS_PROFILE2", columns={"ID_PROFILE"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserHasProfileRepository")
 */
class UserHasProfile extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_USER_PROFILE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserProfile;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;

    /**
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PROFILE", referencedColumnName="ID_PROFILE")
     * })
     */
    private $idProfile;

    public function getIdUserProfile(): ?int
    {
        return $this->idUserProfile;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
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


}
