<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("player")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups("player")
     */
    private $IDLodestone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("player")
     */
    private $server;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerJob", mappedBy="player", orphanRemoval=true, cascade={"persist"})
     * @Groups("player")
     */
    private $playerJobs;

    public function __construct()
    {
        $this->playerJobs = new ArrayCollection();
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
}