<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu", indexes={@ORM\Index(name="fk_correspond", columns={"id_module"}), @ORM\Index(name="fk_menu_status", columns={"id_menu_status"})})
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_menu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_code", type="string", length=50, nullable=false)
     */
    private $menuCode;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_name", type="string", length=50, nullable=false)
     */
    private $menuName;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_link", type="string", length=200, nullable=false)
     */
    private $menuLink;

    /**
     * @var \Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_module", referencedColumnName="id_module")
     * })
     */
    private $idModule;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_menu_status", referencedColumnName="id_catalog")
     * })
     */
    private $idMenuStatus;

    public function getIdMenu(): ?int
    {
        return $this->idMenu;
    }

    public function getMenuCode(): ?string
    {
        return $this->menuCode;
    }

    public function setMenuCode(string $menuCode): self
    {
        $this->menuCode = $menuCode;

        return $this;
    }

    public function getMenuName(): ?string
    {
        return $this->menuName;
    }

    public function setMenuName(string $menuName): self
    {
        $this->menuName = $menuName;

        return $this;
    }

    public function getMenuLink(): ?string
    {
        return $this->menuLink;
    }

    public function setMenuLink(string $menuLink): self
    {
        $this->menuLink = $menuLink;

        return $this;
    }

    public function getIdModule(): ?Module
    {
        return $this->idModule;
    }

    public function setIdModule(?Module $idModule): self
    {
        $this->idModule = $idModule;

        return $this;
    }

    public function getIdMenuStatus(): ?Catalogue
    {
        return $this->idMenuStatus;
    }

    public function setIdMenuStatus(?Catalogue $idMenuStatus): self
    {
        $this->idMenuStatus = $idMenuStatus;

        return $this;
    }


}
