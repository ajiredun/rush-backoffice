<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     collectionOperations={
     *      "get"={"security"="is_granted('ROLE_FOO')"},
     *      "post"={"security"="is_granted('ROLE_FOO')"}
 *      },
 *     itemOperations={
     *     "get"={"security"="is_granted('ROLE_FOO')"},
     *     "put"={"security"="is_granted('ROLE_FOO')"},
     * }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{

    /*
     * accessControl="is_granted('ROLE_FOO')",
 *     accessControlMessage="UNAUTHORISED_API_REQUEST"
     *
     */

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("write")
     */
    private $route;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastModifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lastModifiedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Layout", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $layout;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seoTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seoMetaDescription;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seoAllowRobot;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seoAuthor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seoKeywords;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedOn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $publishedBy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Block", mappedBy="page", orphanRemoval=true,cascade={"persist"})
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
