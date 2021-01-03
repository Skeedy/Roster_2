<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping\OrderBy;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("player")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("player")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups("player")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $IDLodestone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("player")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $server;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerJob", mappedBy="player", orphanRemoval=true, cascade={"persist"})
     * @Groups("player")
     * @Groups("roster")
     * @Groups("playerloot")
     * @OrderBy({"ord" = "ASC"})
     */
    private $playerJobs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roster", inversedBy="player")
     * @Groups("player")
     */
    private $roster;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("player")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $imgUrl;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("player")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $portrait;

    /**
     * @ORM\OneToMany(targetEntity=Loot::class, mappedBy="player", orphanRemoval=true)
     * @Groups("roster")
     */
    private $loots;


    public function __construct()
    {
        $this->playerJobs = new ArrayCollection();
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

    public function getIDLodestone(): ?int
    {
        return $this->IDLodestone;
    }

    public function setIDLodestone(int $IDLodestone): self
    {
        $this->IDLodestone = $IDLodestone;

        return $this;
    }

    public function getServer(): ?string
    {
        return $this->server;
    }

    public function setServer(string $server): self
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return Collection|PlayerJob[]
     */
    public function getPlayerJobs(): Collection
    {
        return $this->playerJobs;
    }

    public function addPlayerJob(PlayerJob $playerJob): self
    {
        if (!$this->playerJobs->contains($playerJob)) {
            $this->playerJobs[] = $playerJob;
            $playerJob->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerJob(PlayerJob $playerJob): self
    {
        if ($this->playerJobs->contains($playerJob)) {
            $this->playerJobs->removeElement($playerJob);
            // set the owning side to null (unless already changed)
            if ($playerJob->getPlayer() === $this) {
                $playerJob->setPlayer(null);
            }
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

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(?string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    public function getPortrait(): ?string
    {
        return $this->portrait;
    }

    public function setPortrait(string $portrait): self
    {
        $this->portrait = $portrait;

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
            $loot->setPlayer($this);
        }

        return $this;
    }

    public function removeLoot(Loot $loot): self
    {
        if ($this->loots->removeElement($loot)) {
            // set the owning side to null (unless already changed)
            if ($loot->getPlayer() === $this) {
                $loot->setPlayer(null);
            }
        }

        return $this;
    }

}
