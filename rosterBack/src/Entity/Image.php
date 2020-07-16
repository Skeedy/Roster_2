<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\Column(type="jobShow")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("jobShow")
     * @Groups("loots")
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("roster")
     * @Groups("jobStuff")
     * @Groups("jobShow")
     * @Groups("loots")
     */
    private $imgpath;
    /**
     * @Assert\File(mimeTypes={ "image/jpg","image/png","image/jpeg" })
     */
    private $file;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getImgpath(): ?string
    {
        return $this->imgpath;
    }

    public function setImgpath(string $imgpath): self
    {
        $this->imgpath = $imgpath;

        return $this;
    }
    public function getFile()
    {
        return $this->file;
    }
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    public function __toString()
    {
        return $this->getImgpath();
    }
}
