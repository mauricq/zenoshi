<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picturepool
 *
 * @ORM\Table(name="picturepool", indexes={@ORM\Index(name="FK_PICTURE_POOL_FILES", columns={"ID_FILE"}), @ORM\Index(name="FK_RECEIP_PICTURE_POOL", columns={"ID_RECEIP"})})
 * @ORM\Entity(repositoryClass="App\Repository\PicturepoolRepository")
 */
class Picturepool extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PICTURE_POOL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPicturePool;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATION_DATE", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FILE", referencedColumnName="ID_FILE")
     * })
     */
    private $idFile;

    /**
     * @var \Receip
     *
     * @ORM\ManyToOne(targetEntity="Receip")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_RECEIP", referencedColumnName="ID_RECEIP")
     * })
     */
    private $idReceip;

    public function getIdPicturePool(): ?int
    {
        return $this->idPicturePool;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getIdFile(): ?File
    {
        return $this->idFile;
    }

    public function setIdFile(?File $idFile): self
    {
        $this->idFile = $idFile;

        return $this;
    }

    public function getIdReceip(): ?Receip
    {
        return $this->idReceip;
    }

    public function setIdReceip(?Receip $idReceip): self
    {
        $this->idReceip = $idReceip;

        return $this;
    }


}
