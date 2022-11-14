<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\Length(
        min:3, 
        max: 10, 
        minMessage:"La taille minimale est 3",
        maxMessage:"La taille maximale est 10",
        )]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    private ?string $name = null;
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    #[ORM\ManyToMany(targetEntity: Hobby::class, mappedBy: 'hob_personne')]
    private Collection $hobbies;

    #[ORM\OneToMany(mappedBy: 'personne_id', targetEntity: Job::class)]
    private Collection $jobs;

    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
        $this->jobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobby $hobby): self
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies->add($hobby);
            $hobby->addHobPersonne($this);
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): self
    {
        if ($this->hobbies->removeElement($hobby)) {
            $hobby->removeHobPersonne($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Job>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
            $job->setPersonneId($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getPersonneId() === $this) {
                $job->setPersonneId(null);
            }
        }

        return $this;
    }
}
