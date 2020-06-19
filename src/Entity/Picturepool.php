<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picturepool
 *
 * @ORM\Table(name="picturepool", indexes={@ORM\Index(name="fk_picture_pool_files", columns={"id_file"}), @ORM\Index(name="fk_receip_picture_pool", columns={"id_receip"})})
 * @ORM\Entity(repositoryClass="App\Repository\PicturepoolRepository")
 */
class Picturepool extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_picture_pool", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPicturePool;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_file", referencedColumnName="id_file")
     * })
     */
    private $idFile;

    /**
     * @var \Receip
     *
     * @ORM\ManyToOne(targetEntity="Receip")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_receip", referencedColumnName="id_receip")
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
