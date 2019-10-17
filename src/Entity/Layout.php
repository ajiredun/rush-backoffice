<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     accessControl="is_granted('ROLE_API_USER', object)",
 *     accessControlMessage="UNAUTHORISED_API_REQUEST"
 * )
 * @ORM\Entity(repositoryClass="App\Repository\LayoutRepository")
 */
class Layout
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"page:read","pages:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"page:read","pages:read"})
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"page:read","pages:read"})
     */
    private $visual;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"page:read","pages:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"page:read","pages:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Groups({"page:read","pages:read"})
     */
    private $structure;

    /**
     * @ORM\Column(type="json")
     * @Groups({"page:read","pages:read"})
     */
    private $slots = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualPack", inversedBy="layouts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"page:read","pages:read"})
     */
    private $visualPack;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="layout", orphanRemoval=true)
     */
    private $pages;

    /**
     * Layout constructor.
     */
    public function __construct()
    {
        $this->visual = 'assets/admin/img/sketch.jpg';
        $this->pages = new ArrayCollection();
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

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setLayout($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getLayout() === $this) {
                $page->setLayout(null);
            }
        }

        return $this;
    }
}
