<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Annotation\Groups;


class UserFacebook extends EntityProvider
{
    /**
     * @var int
     * @SerializedName("id")
     * @Serializer\Type("int")
     *
     */
    private int $id;

    /**
     * @var string|null
     * @SerializedName("email")
     * @Serializer\Type("string")
     *
     */
    private ?string $email;

    /**
     * @var string|null
     * @SerializedName("first_name")
     * @Serializer\Type("string")
     *
     */
    private ?string $firstName;

    /**
     * @var string|null
     * @SerializedName("last_name")
     * @Serializer\Type("string")
     *
     */
    private ?string $lastName;

    /**
     * @var string|null
     * @SerializedName("name")
     * @Serializer\Type("string")
     *
     */
    private ?string $name;

    /**
     * @var string|null
     * @SerializedName("picture_large")
     * @Serializer\Type("string")
     *
     */
    private ?string $pictureLarge;



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPictureLarge(): ?string
    {
        return $this->pictureLarge;
    }

    /**
     * @param string|null $pictureLarge
     */
    public function setPictureLarge(?string $pictureLarge): void
    {
        $this->pictureLarge = $pictureLarge;
    }



}
