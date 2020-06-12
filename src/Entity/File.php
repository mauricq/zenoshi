<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="ID_FILE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFile;

    /**
     * @var string
     *
     * @ORM\Column(name="FILE_NAME", type="string", length=100, nullable=false)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="FILE_LOCATION", type="string", length=200, nullable=false)
     */
    private $fileLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="FILE_REAL_NAME", type="string", length=200, nullable=false)
     */
    private $fileRealName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="SIZE", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATION_DATE", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="STATUS", type="string", length=10, nullable=true)
     */
    private $status;

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
