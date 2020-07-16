<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LootRepository")
 */
class Loot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("roster")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Instance", inversedBy="loots")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $instance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlayerJob", inversedBy="loots")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $playerjob;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Week", inversedBy="loots")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $week;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roster", inversedBy="loots")
     */
    private $roster;

    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstance(): ?Instance
    {
        return $this->instance;
    }

    public function setInstance(?Instance $instance): self
    {
        $this->instance = $instance;

        return $this;
    }

    public function getPlayerjob(): ?PlayerJob
    {
        return $this->playerjob;
    }

    public function setPlayerjob(?PlayerJob $playerjob): self
    {
        $this->playerjob = $playerjob;

        return $this;
    }

    public function getWeek(): ?Week
    {
        return $this->week;
    }

    public function setWeek(?Week $week): self
    {
        $this->week = $week;

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

    public function getRoster(): ?Roster
    {
        return $this->roster;
    }

    public function setRoster(?Roster $roster): self
    {
        $this->roster = $roster;

        return $this;
    }
}
