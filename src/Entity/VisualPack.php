<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\VisualPackRepository")
 */
class VisualPack
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
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Layout", mappedBy="visualPack", orphanRemoval=true)
     */
    private $layouts;

    public function __construct()
    {
        $this->layouts = new ArrayCollection();
    }

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Layout[]
     */
    public function getLayouts(): Collection
    {
        return $this->layouts;
    }

    public function addLayout(Layout $layout): self
    {
        if (!$this->layouts->contains($layout)) {
            $this->layouts[] = $layout;
            $layout->setVisualPack($this);
        }

        return $this;
    }

    public function removeLayout(Layout $layout): self
    {
        if ($this->layouts->contains($layout)) {
            $this->layouts->removeElement($layout);
            // set the owning side to null (unless already changed)
            if ($layout->getVisualPack() === $this) {
                $layout->setVisualPack(null);
            }
        }

        return $this;
    }
}
