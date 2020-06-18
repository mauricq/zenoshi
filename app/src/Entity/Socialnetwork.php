<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Socialnetwork
 *
 * @ORM\Table(name="socialnetwork", indexes={@ORM\Index(name="fk_user_socialnetwork", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="App\Repository\SocialnetworkRepository")
 */
class Socialnetwork extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_social_network", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSocialNetwork;

    /**
     * @var string
     *
     * @ORM\Column(name="network", type="string", length=200, nullable=false)
     */
    private $network;

    /**
     * @var string
     *
     * @ORM\Column(name="id_network", type="string", length=200, nullable=false)
     */
    private $idNetwork;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=false)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observation", type="string", length=200, nullable=true)
     */
    private $observation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdSocialNetwork(): ?int
    {
        return $this->idSocialNetwork;
    }

    public function getNetwork(): ?string
    {
        return $this->network;
    }

    public function setNetwork(string $network): self
    {
        $this->network = $network;

        return $this;
    }

    public function getIdNetwork(): ?string
    {
        return $this->idNetwork;
    }

    public function setIdNetwork(string $idNetwork): self
    {
        $this->idNetwork = $idNetwork;

        return $this;
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

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
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


}
