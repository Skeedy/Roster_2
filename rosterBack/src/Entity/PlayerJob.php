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
     * @Groups("roster")
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
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("roster")
     */
    private $job;

    /**
     * @ORM\Column(type="integer")
     * @Groups("roster")
     */
    private $ord;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $head;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $body;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $hand;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $belt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $leg;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $feet;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $neck;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $earring;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $bracelet;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $ring1;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("roster")
     */
    private $ring2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishHead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishBody;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishHand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishWaist;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishLeg;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishFeet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishEarring;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishNeck;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishBracelet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishRing1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("roster")
     */
    private $wishRing2;

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

    public function getHead(): ?bool
    {
        return $this->head;
    }

    public function setHead(?bool $head): self
    {
        $this->head = $head;

        return $this;
    }

    public function getBody(): ?bool
    {
        return $this->body;
    }

    public function setBody(?bool $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getHand(): ?bool
    {
        return $this->hand;
    }

    public function setHand(?bool $hand): self
    {
        $this->hand = $hand;

        return $this;
    }

    public function getBelt(): ?bool
    {
        return $this->belt;
    }

    public function setBelt(?bool $belt): self
    {
        $this->belt = $belt;

        return $this;
    }

    public function getLeg(): ?bool
    {
        return $this->leg;
    }

    public function setLeg(?bool $leg): self
    {
        $this->leg = $leg;

        return $this;
    }

    public function getFeet(): ?bool
    {
        return $this->feet;
    }

    public function setFeet(?bool $feet): self
    {
        $this->feet = $feet;

        return $this;
    }

    public function getNeck(): ?bool
    {
        return $this->neck;
    }

    public function setNeck(?bool $neck): self
    {
        $this->neck = $neck;

        return $this;
    }

    public function getEarring(): ?bool
    {
        return $this->earring;
    }

    public function setEarring(?bool $earring): self
    {
        $this->earring = $earring;

        return $this;
    }

    public function getBracelet(): ?bool
    {
        return $this->bracelet;
    }

    public function setBracelet(?bool $bracelet): self
    {
        $this->bracelet = $bracelet;

        return $this;
    }

    public function getRing1(): ?bool
    {
        return $this->ring1;
    }

    public function setRing1(?bool $ring1): self
    {
        $this->ring1 = $ring1;

        return $this;
    }

    public function getRing2(): ?bool
    {
        return $this->ring2;
    }

    public function setRing2(?bool $ring2): self
    {
        $this->ring2 = $ring2;

        return $this;
    }

    public function getWishHead(): ?Item
    {
        return $this->wishHead;
    }

    public function setWishHead(?Item $wishHead): self
    {
        $this->wishHead = $wishHead;

        return $this;
    }

    public function getWishBody(): ?Item
    {
        return $this->wishBody;
    }

    public function setWishBody(?Item $wishBody): self
    {
        $this->wishBody = $wishBody;

        return $this;
    }

    public function getWishHand(): ?Item
    {
        return $this->wishHand;
    }

    public function setWishHand(?Item $wishHand): self
    {
        $this->wishHand = $wishHand;

        return $this;
    }

    public function getWishWaist(): ?Item
    {
        return $this->wishWaist;
    }

    public function setWishWaist(?Item $wishWaist): self
    {
        $this->wishWaist = $wishWaist;

        return $this;
    }

    public function getWishLeg(): ?Item
    {
        return $this->wishLeg;
    }

    public function setWishLeg(?Item $wishLeg): self
    {
        $this->wishLeg = $wishLeg;

        return $this;
    }

    public function getWishFeet(): ?Item
    {
        return $this->wishFeet;
    }

    public function setWishFeet(?Item $wishFeet): self
    {
        $this->wishFeet = $wishFeet;

        return $this;
    }

    public function getWishEarring(): ?Item
    {
        return $this->wishEarring;
    }

    public function setWishEarring(?Item $wishEarring): self
    {
        $this->wishEarring = $wishEarring;

        return $this;
    }

    public function getWishNeck(): ?Item
    {
        return $this->wishNeck;
    }

    public function setWishNeck(?Item $wishNeck): self
    {
        $this->wishNeck = $wishNeck;

        return $this;
    }

    public function getWishBracelet(): ?Item
    {
        return $this->wishBracelet;
    }

    public function setWishBracelet(?Item $wishBracelet): self
    {
        $this->wishBracelet = $wishBracelet;

        return $this;
    }

    public function getWishRing1(): ?Item
    {
        return $this->wishRing1;
    }

    public function setWishRing1(?Item $wishRing1): self
    {
        $this->wishRing1 = $wishRing1;

        return $this;
    }

    public function getWishRing2(): ?Item
    {
        return $this->wishRing2;
    }

    public function setWishRing2(?Item $wishRing2): self
    {
        $this->wishRing2 = $wishRing2;

        return $this;
    }
}
