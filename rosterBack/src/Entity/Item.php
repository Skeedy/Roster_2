<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("wishItem")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("wishItem")
     */
    private $imgUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("jobStuff")
     * @Groups("roster")
     * @Groups("wishItem")
     */
    private $ilvl;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("item")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("wishItem")
     */
    private $isSavage;

    /**
     * @ORM\Column(type="integer")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     */
    private $LodId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     */
    private $jobType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Slot", inversedBy="items")
     * @Groups("instance")
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("wishItem")
     */
    private $slot;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Job", inversedBy="items")
     */
    private $jobs;

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
}
