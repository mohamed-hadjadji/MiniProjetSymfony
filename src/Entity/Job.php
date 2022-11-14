<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    private ?Personne $personne_id = null;

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

    public function getPersonneId(): ?Personne
    {
        return $this->personne_id;
    }

    public function setPersonneId(?Personne $personne_id): self
    {
        $this->personne_id = $personne_id;

        return $this;
    }
}
