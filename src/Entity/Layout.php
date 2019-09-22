<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\LayoutRepository")
 */
class Layout
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
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $visual;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $structure;

    /**
     * @ORM\Column(type="json_array")
     */
    private $slots = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualPack", inversedBy="layouts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visualPack;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getVisual(): ?string
    {
        return $this->visual;
    }

    public function setVisual(string $visual): self
    {
        $this->visual = $visual;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function setStructure(string $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getSlots(): ?array
    {
        return $this->slots;
    }

    public function setSlots(array $slots): self
    {
        $this->slots = $slots;

        return $this;
    }

    public function getVisualPack(): ?VisualPack
    {
        return $this->visualPack;
    }

    public function setVisualPack(?VisualPack $visualPack): self
    {
        $this->visualPack = $visualPack;

        return $this;
    }
}
