<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\OperationDataRepository")
 * @ORM\Table(schema="symfony_ppi")
 */
class OperationData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez saisir le montant")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=4)
     * @Assert\NotBlank(message="Veuillez saisir l'année")
     */
    private $annee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Operation", inversedBy="operationData", cascade={"persist"})
     */
    private $operation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

	public function __toString() {
		return $this->getOperation()->getLibelle();
	}
}
