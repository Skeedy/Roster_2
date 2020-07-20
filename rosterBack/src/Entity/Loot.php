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
     * @Groups("loots")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roster", inversedBy="loots")
     * @Groups("loots")
     */
    private $roster;

    /**
     * @ORM\Column(type="integer")
     * @Groups("loots")
     */
    private $week;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlayerJob", inversedBy="loots")
     * @Groups("loots")
     */
    private $playerjob;


    /**
     * @ORM\Column(type="integer")
     * @Groups("loots")
     */
    private $chest;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Instance", inversedBy="loots")
     * @Groups("loots")
     */
    private $instance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $item;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(int $Week): self
    {
        $this->week = $Week;

        return $this;
    }


    public function getPlayerJob(): ?PlayerJob
    {
        return $this->playerjob;
    }

    public function setPlayerJob(?PlayerJob $playerjob): self
    {
        $this->playerjob = $playerjob;

        return $this;
    }

    public function getChest(): ?int
    {
        return $this->chest;
    }

    public function setChest(int $chest): self
    {
        $this->chest = $chest;

        return $this;
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

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

}
