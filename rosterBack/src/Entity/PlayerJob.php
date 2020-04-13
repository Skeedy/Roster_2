<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerJobRepository")
 */
class PlayerJob
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("player")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("player")
     */
    private $isMain;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("player")
     */
    private $isSub;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="playerJobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $job;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsMain(): ?bool
    {
        return $this->isMain;
    }

    public function setIsMain(bool $isMain): self
    {
        $this->isMain = $isMain;

        return $this;
    }

    public function getIsSub(): ?bool
    {
        return $this->isSub;
    }

    public function setIsSub(bool $isSub): self
    {
        $this->isSub = $isSub;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }
}
