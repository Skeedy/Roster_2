<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SlotRepository")
 */
class Slot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("instance")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("wishItem")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("instance")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("jobStuff")
     */
    private $lodId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="slot")
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

    public function getLodId(): ?int
    {
        return $this->lodId;
    }

    public function setLodId(?int $lodId): self
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
            $item->setSlot($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getSlot() === $this) {
                $item->setSlot(null);
            }
        }

        return $this;
    }
}
