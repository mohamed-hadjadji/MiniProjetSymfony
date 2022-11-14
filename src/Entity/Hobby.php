<?php

namespace App\Entity;

use App\Repository\HobbyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HobbyRepository::class)]
class Hobby
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $designation = null;

    #[ORM\ManyToMany(targetEntity: Personne::class, inversedBy: 'hobbies')]
    private Collection $hob_personne;

    public function __construct()
    {
        $this->hob_personne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getHobPersonne(): Collection
    {
        return $this->hob_personne;
    }

    public function addHobPersonne(Personne $hobPersonne): self
    {
        if (!$this->hob_personne->contains($hobPersonne)) {
            $this->hob_personne->add($hobPersonne);
        }

        return $this;
    }

    public function removeHobPersonne(Personne $hobPersonne): self
    {
        $this->hob_personne->removeElement($hobPersonne);

        return $this;
    }
}
