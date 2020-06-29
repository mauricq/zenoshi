<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="fk_person_user", columns={"id_person"}), @ORM\Index(name="fk_user_status", columns={"id_user_status"}), @ORM\Index(name="fk_user_type", columns={"id_user_type"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends EntityProvider implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     * @Serializer\Exclude()
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plainpassword", type="string", length=255, nullable=true)
     */
    private $plainpassword;

    /**
     * @var string
     *
     * @ORM\Column(name="unique_id", type="string", length=200, nullable=false)
     */
    private $uniqueId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="salt", type="string", length=50, nullable=true)
     */
    private $salt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="roles", type="string", length=100, nullable=true)
     */
    private $roles;

    /**
     * @var string|null
     *
     * @ORM\Column(name="app_key", type="string", length=191, nullable=true)
     */
    private $appKey;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_person", referencedColumnName="id_person")
     * })
     */
    private $idPerson;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_status", referencedColumnName="id_catalog")
     * })
     */
    private $idUserStatus;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_type", referencedColumnName="id_catalog")
     * })
     */
    private $idUserType;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainpassword(): ?string
    {
        return $this->plainpassword;
    }

    public function setPlainpassword(?string $plainpassword): self
    {
        $this->plainpassword = $plainpassword;

        return $this;
    }

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(?string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getRoles(): ?array
    {
        return [$this->roles];
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = implode(" ", $roles);

        return $this;
    }

    public function getAppKey(): ?string
    {
        return $this->appKey;
    }

    public function setAppKey(?string $appKey): self
    {
        $this->appKey = $appKey;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getIdUserStatus(): ?Catalogue
    {
        return $this->idUserStatus;
    }

    public function setIdUserStatus(?Catalogue $idUserStatus): self
    {
        $this->idUserStatus = $idUserStatus;

        return $this;
    }

    public function getIdUserType(): ?Catalogue
    {
        return $this->idUserType;
    }

    public function setIdUserType(?Catalogue $idUserType): self
    {
        $this->idUserType = $idUserType;

        return $this;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @var string|null
     *
     */
    private $statusFacebook;

    /**
     * @return string|null
     */
    public function getStatusFacebook(): ?string
    {
        return $this->statusFacebook;
    }

    /**
     * @param string|null $statusFacebook
     */
    public function setStatusFacebook(?string $statusFacebook): void
    {
        $this->statusFacebook = $statusFacebook;
    }
}
