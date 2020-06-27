<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_file", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFile;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=100, nullable=false)
     * @Groups({"reward"})
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="file_location", type="string", length=200, nullable=false)
     * @Groups({"reward"})
     */
    private $fileLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="file_real_name", type="string", length=200, nullable=false)
     */
    private $fileRealName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=true)
     */
    private $status;

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->creationDate = date_create();
    }

    public function getIdFile(): ?int
    {
        return $this->idFile;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileLocation(): ?string
    {
        return $this->fileLocation;
    }

    public function setFileLocation(string $fileLocation): self
    {
        $this->fileLocation = $fileLocation;

        return $this;
    }

    public function getFileRealName(): ?string
    {
        return $this->fileRealName;
    }

    public function setFileRealName(string $fileRealName): self
    {
        $this->fileRealName = $fileRealName;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }


}
