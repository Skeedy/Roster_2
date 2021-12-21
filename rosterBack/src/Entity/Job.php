<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping\OrderBy;

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
     * @Groups("instance")
     * @Groups("jobShow")
     * @Groups("loots")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("jobShow")
     * @Groups("instance")
     * @Groups("loots")
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("jobShow")
     * @Groups("instance")
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("jobShow")
     * @Groups("instance")
     */
    private $subrole;

    /**
     * @ORM\Column(type="integer")
     * @Groups("jobShow")
     */
    private $lodId;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item", mappedBy="jobs")
     * @Groups("jobStuff")
     * @OrderBy({"ilvl" = "ASC"})
     */
    private $items;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("jobShow")
     */
    private $imgUrl;

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
            $item->addJob($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            $item->removeJob($this);
        }

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(?string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

}
