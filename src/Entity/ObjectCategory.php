<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjectCategoryRepository")
 */
class ObjectCategory
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastModifedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $lastModifiedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ObjectCategory", inversedBy="objectCategories")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjectCategory", mappedBy="category")
     */
    private $objectCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjectProduct", mappedBy="category")
     */
    private $objectProducts;

    public function __construct()
    {
        $this->objectCategories = new ArrayCollection();
        $this->objectProducts = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getLastModifedAt(): ?\DateTimeInterface
    {
        return $this->lastModifedAt;
    }

    public function setLastModifedAt(\DateTimeInterface $lastModifedAt): self
    {
        $this->lastModifedAt = $lastModifedAt;

        return $this;
    }

    public function getLastModifiedBy(): ?User
    {
        return $this->lastModifiedBy;
    }

    public function setLastModifiedBy(?User $lastModifiedBy): self
    {
        $this->lastModifiedBy = $lastModifiedBy;

        return $this;
    }

    public function getCategory(): ?self
    {
        return $this->category;
    }

    public function setCategory(?self $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getObjectCategories(): Collection
    {
        return $this->objectCategories;
    }

    public function addObjectCategory(self $objectCategory): self
    {
        if (!$this->objectCategories->contains($objectCategory)) {
            $this->objectCategories[] = $objectCategory;
            $objectCategory->setCategory($this);
        }

        return $this;
    }

    public function removeObjectCategory(self $objectCategory): self
    {
        if ($this->objectCategories->contains($objectCategory)) {
            $this->objectCategories->removeElement($objectCategory);
            // set the owning side to null (unless already changed)
            if ($objectCategory->getCategory() === $this) {
                $objectCategory->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ObjectProduct[]
     */
    public function getObjectProducts(): Collection
    {
        return $this->objectProducts;
    }

    public function addObjectProduct(ObjectProduct $objectProduct): self
    {
        if (!$this->objectProducts->contains($objectProduct)) {
            $this->objectProducts[] = $objectProduct;
            $objectProduct->setCategory($this);
        }

        return $this;
    }

    public function removeObjectProduct(ObjectProduct $objectProduct): self
    {
        if ($this->objectProducts->contains($objectProduct)) {
            $this->objectProducts->removeElement($objectProduct);
            // set the owning side to null (unless already changed)
            if ($objectProduct->getCategory() === $this) {
                $objectProduct->setCategory(null);
            }
        }

        return $this;
    }
}
