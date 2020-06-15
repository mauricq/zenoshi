<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="FK_PERSON_USER", columns={"ID_PERSON"}), @ORM\Index(name="FK_USER_STATUS", columns={"ID_CATALOG"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserEntityRepository")
 */
class User extends EntityProvider implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_USER", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="USERNAME", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PASSWORD", type="string", length=255, nullable=true)
     * @Serializer\Exclude()
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PLAINPASSWORD", type="string", length=255, nullable=true)
     */
    private $plainpassword;

    /**
     * @var string
     *
     * @ORM\Column(name="UNIQUE_ID", type="string", length=200, nullable=false)
     */
    private $uniqueId;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SALT", type="string", length=50, nullable=true)
     */
    private $salt;

    /**
     * @var array|null
     *
     * @ORM\Column(name="ROLES", type="json", length=100, nullable=true)
     */
    private $roles = [];

    /**
     * @var string|null
     *
     * @ORM\Column(name="APP_KEY", type="string", length=191, nullable=true)
     */
    private $appKey;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="CREATED_AT", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="UPDATED_AT", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PERSON", referencedColumnName="ID_PERSON")
     * })
     */
    private $idPerson;

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
     * @ORM\ManyToMany(targetEntity="Profile", inversedBy="idUser")
     * @ORM\JoinTable(name="user_has_profile",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_PROFILE", referencedColumnName="ID_PROFILE")
     *   }
     * )
     */
    private $idProfile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProfile = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles() : array
    {
        return ["ROLE_USER"];
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
        }

        return $this;
    }

    public function removeIdProfile(Profile $idProfile): self
    {
        if ($this->idProfile->contains($idProfile)) {
            $this->idProfile->removeElement($idProfile);
        }

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
}
