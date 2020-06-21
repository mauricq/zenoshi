<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="fk_client_location", columns={"id_client_location"}), @ORM\Index(name="fk_person_picture", columns={"id_person_picture"}), @ORM\Index(name="fk_person_status", columns={"id_person_status"})})
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_person", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100, nullable=false)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="identification_type", type="string", length=50, nullable=true)
     */
    private $identificationType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="identification_number", type="string", length=20, nullable=true)
     */
    private $identificationNumber;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=20, nullable=false)
     */
    private $mobile;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=200, nullable=true)
     */
    private $address;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client_location", referencedColumnName="id_catalog")
     * })
     */
    private $idClientLocation;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_person_picture", referencedColumnName="id_file")
     * })
     */
    private $idPersonPicture;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_person_status", referencedColumnName="id_catalog")
     * })
     */
    private $idPersonStatus;

    public function getIdPerson(): ?int
    {
        return $this->idPerson;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getIdentificationType(): ?string
    {
        return $this->identificationType;
    }

    public function setIdentificationType(?string $identificationType): self
    {
        $this->identificationType = $identificationType;

        return $this;
    }

    public function getIdentificationNumber(): ?string
    {
        return $this->identificationNumber;
    }

    public function setIdentificationNumber(?string $identificationNumber): self
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getIdClientLocation(): ?Catalogue
    {
        return $this->idClientLocation;
    }

    public function setIdClientLocation(?Catalogue $idClientLocation): self
    {
        $this->idClientLocation = $idClientLocation;

        return $this;
    }

    public function getIdPersonPicture(): ?File
    {
        return $this->idPersonPicture;
    }

    public function setIdPersonPicture(?File $idPersonPicture): self
    {
        $this->idPersonPicture = $idPersonPicture;

        return $this;
    }

    public function getIdPersonStatus(): ?Catalogue
    {
        return $this->idPersonStatus;
    }

    public function setIdPersonStatus(?Catalogue $idPersonStatus): self
    {
        $this->idPersonStatus = $idPersonStatus;

        return $this;
    }

    /**
     * @param int $idPerson
     */
    public function setIdPerson(int $idPerson): void
    {
        $this->idPerson = $idPerson;
    }

}
