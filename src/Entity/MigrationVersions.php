<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MigrationVersions
 *
 * @ORM\Table(name="doctrine_migration_versions")
 * @ORM\Entity(repositoryClass="App\Repository\MigrationVersionsRepository")
 */
class MigrationVersions extends EntityProvider
{
    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=14, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $version;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="executed_at", type="datetime_immutable", nullable=false)
     */
    private $executedAt;

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function getExecutedAt(): ?\DateTimeImmutable
    {
        return $this->executedAt;
    }

    public function setExecutedAt(\DateTimeImmutable $executedAt): self
    {
        $this->executedAt = $executedAt;

        return $this;
    }


}
