<?php

namespace App\Entity\Objet;

use App\Entity\Admin\Operation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
// use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Objet\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $departement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\Operation", mappedBy="user", cascade={"persist"})
     */
    private $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

	public function getId():  ? int {
		return $this->id;
	}

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $item): self
    {
        $this->departement = $item;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $item): self
    {
        $this->direction = $item;

        return $this;
    }

	public function getOperations(): Collection
	{
		return $this->operations;
	}

    public function addOperations(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setOperation($this);
        }

        return $this;
    }

    public function removeOperations(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getOperation() === $this) {
                $operation->setOperation(null);
            }
        }

        return $this;
    }
}
