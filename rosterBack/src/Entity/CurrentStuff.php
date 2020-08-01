<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrentStuffRepository")
 */
class CurrentStuff
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $head;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $hands;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $belt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $legs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $feet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $earring;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $neck;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $bracelet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $ring1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     * @Groups("loots")
     */
    private $ring2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     */

    private $mainHand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("currentStuff")
     * @Groups("roster")
     */
    private $offHand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevHead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevBody;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevHands;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevBelt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevLegs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevFeet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevEarring;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevNeck;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevBracelet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevRing1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevRing2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $prevMainHand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHead(): ?Item
    {
        return $this->head;
    }

    public function setHead(?Item $head): self
    {
        $this->head = $head;

        return $this;
    }

    public function getBody(): ?Item
    {
        return $this->body;
    }

    public function setBody(?Item $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getHands(): ?Item
    {
        return $this->hands;
    }

    public function setHands(?Item $hands): self
    {
        $this->hands = $hands;

        return $this;
    }

    public function getBelt(): ?Item
    {
        return $this->belt;
    }

    public function setBelt(?Item $belt): self
    {
        $this->belt = $belt;

        return $this;
    }

    public function getLegs(): ?Item
    {
        return $this->legs;
    }

    public function setLegs(?Item $legs): self
    {
        $this->legs = $legs;

        return $this;
    }

    public function getFeet(): ?Item
    {
        return $this->feet;
    }

    public function setFeet(?Item $feet): self
    {
        $this->feet = $feet;

        return $this;
    }

    public function getEarring(): ?Item
    {
        return $this->earring;
    }

    public function setEarring(?Item $earring): self
    {
        $this->earring = $earring;

        return $this;
    }

    public function getNeck(): ?Item
    {
        return $this->neck;
    }

    public function setNeck(?Item $neck): self
    {
        $this->neck = $neck;

        return $this;
    }

    public function getBracelet(): ?Item
    {
        return $this->bracelet;
    }

    public function setBracelet(?Item $bracelet): self
    {
        $this->bracelet = $bracelet;

        return $this;
    }

    public function getRing1(): ?Item
    {
        return $this->ring1;
    }

    public function setRing1(?Item $ring1): self
    {
        $this->ring1 = $ring1;

        return $this;
    }

    public function getRing2(): ?Item
    {
        return $this->ring2;
    }

    public function setRing2(?Item $ring2): self
    {
        $this->ring2 = $ring2;

        return $this;
    }


    public function getMainHand(): ?Item
    {
        return $this->mainHand;
    }

    public function setMainHand(?Item $mainHand): self
    {
        $this->mainHand = $mainHand;

        return $this;
    }

    public function getOffHand(): ?Item
    {
        return $this->offHand;
    }

    public function setOffHand(?Item $offHand): self
    {
        $this->offHand = $offHand;

        return $this;
    }

    public function getPrevHead(): ?Item
    {
        return $this->prevHead;
    }

    public function setPrevHead(?Item $prevHead): self
    {
        $this->prevHead = $prevHead;

        return $this;
    }

    public function getPrevBody(): ?Item
    {
        return $this->prevBody;
    }

    public function setPrevBody(?Item $prevBody): self
    {
        $this->prevBody = $prevBody;

        return $this;
    }

    public function getPrevHands(): ?Item
    {
        return $this->prevHands;
    }

    public function setPrevHands(?Item $prevHands): self
    {
        $this->prevHands = $prevHands;

        return $this;
    }

    public function getPrevBelt(): ?Item
    {
        return $this->prevBelt;
    }

    public function setPrevBelt(?Item $prevBelt): self
    {
        $this->prevBelt = $prevBelt;

        return $this;
    }

    public function getPrevLegs(): ?Item
    {
        return $this->prevLegs;
    }

    public function setPrevLegs(?Item $prevLegs): self
    {
        $this->prevLegs = $prevLegs;

        return $this;
    }

    public function getPrevFeet(): ?Item
    {
        return $this->prevFeet;
    }

    public function setPrevFeet(?Item $prevFeet): self
    {
        $this->prevFeet = $prevFeet;

        return $this;
    }

    public function getPrevEarring(): ?Item
    {
        return $this->prevEarring;
    }

    public function setPrevEarring(?Item $prevEarring): self
    {
        $this->prevEarring = $prevEarring;

        return $this;
    }

    public function getPrevNeck(): ?Item
    {
        return $this->prevNeck;
    }

    public function setPrevNeck(?Item $prevNeck): self
    {
        $this->prevNeck = $prevNeck;

        return $this;
    }

    public function getPrevBracelet(): ?Item
    {
        return $this->prevBracelet;
    }

    public function setPrevBracelet(?Item $prevBracelet): self
    {
        $this->prevBracelet = $prevBracelet;

        return $this;
    }

    public function getPrevRing1(): ?Item
    {
        return $this->prevRing1;
    }

    public function setPrevRing1(?Item $prevRing1): self
    {
        $this->prevRing1 = $prevRing1;

        return $this;
    }

    public function getPrevRing2(): ?Item
    {
        return $this->prevRing2;
    }

    public function setPrevRing2(?Item $prevRing2): self
    {
        $this->prevRing2 = $prevRing2;

        return $this;
    }

    public function getPrevMainHand(): ?Item
    {
        return $this->prevMainHand;
    }

    public function setPrevMainHand(?Item $prevMainHand): self
    {
        $this->prevMainHand = $prevMainHand;

        return $this;
    }
}
