<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WishItemRepository")
 */
class WishItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $head;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $hands;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $belt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $legs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $feet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $earring;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $neck;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $bracelet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $ring1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $ring2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */

    private $mainHand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     * @Groups("wishItem")
     * @Groups("roster")
     */
    private $offHand;

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
}
