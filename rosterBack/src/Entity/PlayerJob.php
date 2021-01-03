<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Groups("roster")
     * @Groups("loots")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("player")
     * @Groups("roster")
     */
    private $isMain;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("player")
     * @Groups("roster")
     */
    private $isSub;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="playerJobs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("loots")
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("roster")
     * @Groups("loots")
     */
    private $job;

    /**
     * @ORM\Column(type="integer")
     * @Groups("roster")
     */
    private $ord;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\WishItem", cascade={"persist", "remove"})
     * @Groups("roster")
     */
    private $wishitem;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Loot", mappedBy="playerjob", cascade={"persist", "remove"})
     * @Groups("playerloot")
     */
    private $loots;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CurrentStuff", cascade={"persist", "remove"})
     * @Groups("roster")
     */
    private $currentstuff;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Oldstuff", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $oldStuff;

    public function __construct()
    {
        $this->loots = new ArrayCollection();
    }

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

    public function getOrd(): ?int
    {
        return $this->ord;
    }

    public function setOrd(int $ord): self
    {
        $this->ord = $ord;

        return $this;
    }

    public function getWishItem(): ?WishItem
    {
        return $this->wishitem;
    }

    public function setWishItem(?WishItem $wishitem): self
    {
        $this->wishitem = $wishitem;

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
            $loot->setPlayerJob($this);
        }

        return $this;
    }

    public function removeLoot(Loot $loot): self
    {
        if ($this->loots->contains($loot)) {
            $this->loots->removeElement($loot);
            // set the owning side to null (unless already changed)
            if ($loot->getPlayerJob() === $this) {
                $loot->setPlayerJob(null);
            }
        }

        return $this;
    }

    public function getCurrentstuff(): ?CurrentStuff
    {
        return $this->currentstuff;
    }

    public function setCurrentstuff(?CurrentStuff $currentstuff): self
    {
        $this->currentstuff = $currentstuff;

        return $this;
    }

    public function getOldStuff(): ?Oldstuff
    {
        return $this->oldStuff;
    }

    public function setOldStuff(Oldstuff $oldStuff): self
    {
        $this->oldStuff = $oldStuff;

        return $this;
    }
}
