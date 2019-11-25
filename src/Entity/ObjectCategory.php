<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *
 * @ApiResource(
 *      attributes={
 *          "pagination_items_per_page"=3000
 *     },
 *     accessControl="is_granted('ROLE_API_USER', object)",
 *     accessControlMessage="UNAUTHORISED_API_REQUEST",
 *     normalizationContext={"groups"={"category:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"category:write"}, "swagger_definition_name"="Write"},
 *     collectionOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"category:read"}}
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ObjectCategoryRepository")
 */
class ObjectCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"category:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category:read"})
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"category:read"})
     */
    private $online;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"category:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category:read"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"category:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastModifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $lastModifiedBy;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ObjectCategory", inversedBy="objectCategories")
     * @ApiSubresource()
     * @Groups({"category:read"})
     */
    private $category;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\ObjectCategory", mappedBy="category")
     * @ApiSubresource()
     * @Groups({"category:read"})
     */
    private $objectCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjectProduct", mappedBy="category")
     * @ApiSubresource()
     * @Groups({"category:read"})
     */
    private $objectProducts;

    public function __construct()
    {
        $this->lastModifiedAt = new \DateTime('now');
        $this->createdAt = new \DateTime('now');
        $this->objectCategories = new ArrayCollection();
        $this->objectProducts = new ArrayCollection();
        $this->online = false;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }


    function slugify($sluggable)
    {
        $sluggable = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $sluggable);
        $sluggable = trim($sluggable, '-');
        if( function_exists('mb_strtolower') ) {
            $sluggable = mb_strtolower( $sluggable );
        } else {
            $sluggable = strtolower( $sluggable );
        }
        $sluggable = preg_replace("/[\/_|+ -]+/", '-', $sluggable);

        return $sluggable;
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

    public function getLastModifiedAt(): ?\DateTimeInterface
    {
        return $this->lastModifiedAt;
    }

    public function setLastModifiedAt(\DateTimeInterface $lastModifiedAt): self
    {
        $this->lastModifiedAt = $lastModifiedAt;

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
