<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu", indexes={@ORM\Index(name="FK_CORRESPOND", columns={"ID_MODULE"}), @ORM\Index(name="FK_MENU_STATUS", columns={"ID_MENU_STATUS"})})
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu extends EntityProvider
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_MENU", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="MENU_CODE", type="string", length=50, nullable=false)
     */
    private $menuCode;

    /**
     * @var string
     *
     * @ORM\Column(name="MENU_NAME", type="string", length=50, nullable=false)
     */
    private $menuName;

    /**
     * @var string
     *
     * @ORM\Column(name="MENU_LINK", type="string", length=200, nullable=false)
     */
    private $menuLink;

    /**
     * @var \Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MODULE", referencedColumnName="ID_MODULE")
     * })
     */
    private $idModule;

    /**
     * @var \Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MENU_STATUS", referencedColumnName="ID_CATALOG")
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
