<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("instance")
     * @Groups("jobStuff")
     * @Groups("loots")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     * @Groups("item")
     * @Groups("roster")
     * @Groups("playerloot")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     * @Groups("loots")
     * @Groups("playerloot")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     * @Groups("loots")
     */
    private $imgUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("currentStuff")
     * @Groups("wishItem")
     */
    private $ilvl;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     * @Groups("loots")
     */
    private $isSavage;

    /**
     * @ORM\Column(type="integer")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     */
    private $LodId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     */
    private $jobType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Slot", inversedBy="items")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     */
    private $slot;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Job", inversedBy="items")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("item")
     * @OrderBy({"id" = "ASC"})
     */
    private $jobs;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     */
    private $isUpgrade;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     */
    private $isCoffer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $canBeUpgraded;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     * @Groups("currentStuff")
     */
    private $isUpgraded;


    public function __construct()
    {
        $this->jobs = new ArrayCollection();

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

    public function getIlvl(): ?int
    {
        return $this->ilvl;
    }

    public function setIlvl(?int $ilvl): self
    {
        $this->ilvl = $ilvl;

        return $this;
    }

    public function getIsSavage(): ?bool
    {
        return $this->isSavage;
    }

    public function setIsSavage(?bool $isSavage): self
    {
        $this->isSavage = $isSavage;

        return $this;
    }

    public function getLodId(): ?int
    {
        return $this->LodId;
    }

    public function setLodId(int $LodId): self
    {
        $this->LodId = $LodId;

        return $this;
    }

    public function getJobType(): ?string
    {
        return $this->jobType;
    }

    public function setJobType(?string $jobType): self
    {
        $this->jobType = $jobType;

        return $this;
    }

    public function getSlot(): ?Slot
    {
        return $this->slot;
    }

    public function setSlot(?Slot $slot): self
    {
        $this->slot = $slot;

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }

    public function getIsUpgrade(): ?bool
    {
        return $this->isUpgrade;
    }

    public function setIsUpgrade(bool $isUpgrade): self
    {
        $this->isUpgrade = $isUpgrade;

        return $this;
    }

    public function getIsCoffer(): ?bool
    {
        return $this->isCoffer;
    }

    public function setIsCoffer(bool $isCoffer): self
    {
        $this->isCoffer = $isCoffer;

        return $this;
    }

    public function getCanBeUpgraded(): ?bool
    {
        return $this->canBeUpgraded;
    }

    public function setCanBeUpgraded(bool $canBeUpgraded): self
    {
        $this->canBeUpgraded = $canBeUpgraded;

        return $this;
    }

    public function getIsUpgraded(): ?bool
    {
        return $this->isUpgraded;
    }

    public function setIsUpgraded(bool $isUpgraded): self
    {
        $this->isUpgraded = $isUpgraded;

        return $this;
    }
}
