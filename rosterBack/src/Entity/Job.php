<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("roster")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("roster")
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("roster")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subrole;

    /**
     * @ORM\Column(type="integer")
     */
    private $lodId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="job")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSubrole(): ?string
    {
        return $this->subrole;
    }

    public function setSubrole(?string $subrole): self
    {
        $this->subrole = $subrole;

        return $this;
    }

    public function getLodId(): ?int
    {
        return $this->lodId;
    }

    public function setLodId(int $lodId): self
    {
        $this->lodId = $lodId;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setJob($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getJob() === $this) {
                $item->setJob(null);
            }
        }

        return $this;
    }

}
