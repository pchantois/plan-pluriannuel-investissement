<?php

namespace App\Entity\Admin;

use App\Repository\Admin\ParamsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParamsRepository::class)
 * @ORM\Table(schema="symfony_ppi")
 */
class Params
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $periodeRef;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriodeRef(): ?string
    {
        return $this->periodeRef;
    }

    public function setPeriodeRef(string $periodeRef): self
    {
        $this->periodeRef = $periodeRef;

        return $this;
    }
}
