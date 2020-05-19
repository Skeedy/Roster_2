<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ilvl;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSavage;

    /**
     * @ORM\Column(type="integer")
     */
    private $LodId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jobType;

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
}
