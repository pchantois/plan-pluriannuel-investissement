<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\QuartierRepository")
 */
class Quartier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\Operation", mappedBy="quartier")
     */
    private $operations;

    public function __construct()
    {
        $this->codeMaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getCodeMaire(): Collection
    {
        return $this->codeMaire;
    }

    public function addCodeMaire(Operation $codeMaire): self
    {
        if (!$this->codeMaire->contains($codeMaire)) {
            $this->codeMaire[] = $codeMaire;
            $codeMaire->setRelation($this);
        }

        return $this;
    }

    public function removeCodeMaire(Operation $codeMaire): self
    {
        if ($this->codeMaire->contains($codeMaire)) {
            $this->codeMaire->removeElement($codeMaire);
            // set the owning side to null (unless already changed)
            if ($codeMaire->getRelation() === $this) {
                $codeMaire->setRelation(null);
            }
        }

        return $this;
    }

	public function __toString() {
		return $this->getLibelle();
	}
}
