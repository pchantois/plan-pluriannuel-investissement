<?php

namespace App\Entity\Admin;

use App\Entity\Objet\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\OperationRepository")
 * @ORM\Table(schema="symfony_ppi")
 * @Vich\Uploadable
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\RegroupementOpe", inversedBy="operations")
     */
    private $regroupementOpe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Quartier", inversedBy="operations")
     * @ORM\OrderBy({"code" = "ASC"})
     */
    private $quartier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\CodeMaire", inversedBy="operations")
     */
    private $codeMaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\NatureOpe", inversedBy="operations")
     */
    private $natureOpe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\PolitiquePub", inversedBy="operations")
     * @ORM\OrderBy({"libelle" = "ASC"})
     */
    private $politiquePub;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=false})
     */
    private $dob;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=false})
     */
    private $recueil;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\OperationData", mappedBy="operation", cascade={"persist"}, orphanRemoval = true)
     * @Assert\Valid()
     * @ORM\OrderBy({"annee" = "ASC"})
     */
    private $operationData;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Objet\User", inversedBy="operations", cascade={"persist"})
     * @ORM\OrderBy({"departement" = "ASC", "direction" = "ASC"})
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateLivraison;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $CoutParti;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $coutTotal;

    public function __construct()
    {
        $this->operationData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getRegroupementOpe(): ?RegroupementOpe
    {
        return $this->regroupementOpe;
    }

    public function setRegroupementOpe(?RegroupementOpe $regroupementOpe): self
    {
        $this->regroupementOpe = $regroupementOpe;

        return $this;
    }

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getCodeMaire(): ?CodeMaire
    {
        return $this->codeMaire;
    }

    public function setCodeMaire(?CodeMaire $codeMaire): self
    {
        $this->codeMaire = $codeMaire;

        return $this;
    }

    public function getNatureOpe(): ?NatureOpe
    {
        return $this->natureOpe;
    }

    public function setNatureOpe(?NatureOpe $NatureOpe): self
    {
        $this->natureOpe = $NatureOpe;

        return $this;
    }

    public function getPolitiquePub(): ?PolitiquePub
    {
        return $this->politiquePub;
    }

    public function setPolitiquePub(?PolitiquePub $PolitiquePub): self
    {
        $this->politiquePub = $PolitiquePub;

        return $this;
    }

    public function getDob(): ?bool
    {
        return $this->dob;
    }

    public function setDob(bool $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getRecueil(): ?bool
    {
        return $this->recueil;
    }

    public function setRecueil(bool $recueil): self
    {
        $this->recueil = $recueil;

        return $this;
    }

    /**
     * @return Collection|OperationData[]
     */
    public function getOperationData(): Collection
    {
        return $this->operationData;
    }

    public function addOperationDatum(OperationData $operationData): self
    {
        if (!$this->operationData->contains($operationData)) {
            $this->operationData[] = $operationData;
            $operationData->setOperation($this);
        }

        return $this;
    }

    public function removeOperationDatum(OperationData $operationData): self
    {
        if ($this->operationData->contains($operationData)) {
            $this->operationData->removeElement($operationData);
            // set the owning side to null (unless already changed)
            if ($operationData->getOperation() === $this) {
                $operationData->setOperation(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

	public function __toString() {
                           		return $this->getLibelle();
                           	}

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->DateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $DateLivraison): self
    {
        $this->DateLivraison = $DateLivraison;

        return $this;
    }

    public function getCoutParti(): ?bool
    {
        return $this->CoutParti;
    }

    public function setCoutParti(?bool $CoutParti): self
    {
        $this->CoutParti = $CoutParti;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getCoutTotal(): ?int
    {
        return $this->coutTotal;
    }

    public function setCoutTotal(?int $coutTotal): self
    {
        $this->coutTotal = $coutTotal;

        return $this;
    }
}
