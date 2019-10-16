<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={
 *          "pagination_items_per_page"=10
 *     },
 *     accessControl="is_granted('ROLE_API_USER', object)",
 *     accessControlMessage="UNAUTHORISED_API_REQUEST",
 *     normalizationContext={"groups"={"page:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"page:write"}, "swagger_definition_name"="Write"},
 * )
 *
 * @ApiFilter(BooleanFilter::class, properties={"published"})
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 *
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"page:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"page:read"})
     * @Assert\NotBlank()
     * @Groups({"page:read"})
     */
    private $route;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"page:read", "page:write"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     maxMessage="Describe your cheese in 50 chars or less"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"page:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"page:read"})
     */
    private $lastModifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"page:read"})
     */
    private $lastModifiedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Layout", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"page:read", "page:write"})
     */
    private $layout;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"page:read", "page:write"})
     */
    private $published;

    /**
     * @ORM\Column(type="json")
     * @Groups({"page:read", "page:write"})
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"page:read", "page:write"})
     */
    private $seoTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"page:read", "page:write"})
     */
    private $seoMetaDescription;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"page:read", "page:write"})
     */
    private $seoAllowRobot;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"page:read", "page:write"})
     */
    private $seoAuthor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"page:read", "page:write"})
     */
    private $seoKeywords;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"page:read"})
     */
    private $publishedOn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @Groups({"page:read"})
     */
    private $publishedBy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Block", mappedBy="page", orphanRemoval=true,cascade={"persist"})
     * @Groups({"page:read", "page:write"})
     * @ApiSubresource()
     */
    private $blocks;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->published = false;
        $this->createdAt = new \DateTime('now');
        $this->lastModifiedAt = $this->createdAt;
        $this->seoAllowRobot = true;
        $this->blocks = new ArrayCollection();
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
            $blocks = $this->getBlocks();
            $blocksArray = new ArrayCollection();
            foreach ($blocks as $b) {
                /**
                 * @var Block $b
                 */
                $blockClone = clone $b;
                $blockClone->setPage($this);
                $blocksArray->add($blockClone);
            }
            $this->blocks = $blocksArray;
            $this->lastModifiedAt = new \DateTime('now');
        }
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
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

    public function getLayout(): ?Layout
    {
        return $this->layout;
    }

    public function setLayout(?Layout $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSeoTitle(): ?string
    {
        return $this->seoTitle;
    }

    public function setSeoTitle(?string $seoTitle): self
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    public function getSeoMetaDescription(): ?string
    {
        return $this->seoMetaDescription;
    }

    public function setSeoMetaDescription(?string $seoMetaDescription): self
    {
        $this->seoMetaDescription = $seoMetaDescription;

        return $this;
    }

    public function getSeoAllowRobot(): ?bool
    {
        return $this->seoAllowRobot;
    }

    public function setSeoAllowRobot(bool $seoAllowRobot): self
    {
        $this->seoAllowRobot = $seoAllowRobot;

        return $this;
    }

    public function getSeoAuthor(): ?string
    {
        return $this->seoAuthor;
    }

    public function setSeoAuthor(?string $seoAuthor): self
    {
        $this->seoAuthor = $seoAuthor;

        return $this;
    }

    public function getSeoKeywords(): ?string
    {
        return $this->seoKeywords;
    }

    public function setSeoKeywords(?string $seoKeywords): self
    {
        $this->seoKeywords = $seoKeywords;

        return $this;
    }

    public function getPublishedOn(): ?\DateTimeInterface
    {
        return $this->publishedOn;
    }

    public function setPublishedOn(?\DateTimeInterface $publishedOn): self
    {
        $this->publishedOn = $publishedOn;

        return $this;
    }

    public function getPublishedBy(): ?User
    {
        return $this->publishedBy;
    }

    public function setPublishedBy(?User $publishedBy): self
    {
        $this->publishedBy = $publishedBy;

        return $this;
    }

    /**
     * @return Collection|Block[]
     */
    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function addBlock(Block $block): self
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks[] = $block;
            $block->setPage($this);
        }

        return $this;
    }

    public function removeBlock(Block $block): self
    {
        if ($this->blocks->contains($block)) {
            $this->blocks->removeElement($block);
            // set the owning side to null (unless already changed)
            if ($block->getPage() === $this) {
                $block->setPage(null);
            }
        }

        return $this;
    }
}
