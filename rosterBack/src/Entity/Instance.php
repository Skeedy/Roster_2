<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstanceRepository")
 */
class Instance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("instance")
     * @Groups("loots")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("instance")
     * @Groups("loots")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("instance")
     * @Groups("loots")
     */
    private $imgUrl;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item")
     * @Groups("instance")
     */
    private $item;

    /**
     * @ORM\Column(type="integer")
     * @Groups("instance")
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Loot", mappedBy="instance")
     */
    private $loots;


    public function __construct()
    {
        $this->item = new ArrayCollection();
        $this->loots = new ArrayCollection();
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

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(Item $item): self
    {
        if (!$this->item->contains($item)) {
            $this->item[] = $item;
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->item->contains($item)) {
            $this->item->removeElement($item);
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

    /**
     * @return Collection|Loot[]
     */
    public function getLoots(): Collection
    {
        return $this->loots;
    }

    public function addLoot(Loot $loot): self
    {
        if (!$this->loots->contains($loot)) {
            $this->loots[] = $loot;
            $loot->setInstance($this);
        }

        return $this;
    }

    public function removeLoot(Loot $loot): self
    {
        if ($this->loots->contains($loot)) {
            $this->loots->removeElement($loot);
            // set the owning side to null (unless already changed)
            if ($loot->getInstance() === $this) {
                $loot->setInstance(null);
            }
        }

        return $this;
    }
}
