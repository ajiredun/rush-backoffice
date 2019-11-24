<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ObjectProductRepository")
 */
class ObjectProduct
{
    /**
     * @ORM\Id()Men
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referenceNo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $briefDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ObjectCategory", inversedBy="objectProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
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
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image02;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image03;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image04;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image05;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image06;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image07;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image08;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image09;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute01;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute01Value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute02;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute02Value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute03;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute03Value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute04;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute04Value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute05;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attribute05Value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $question01;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $question02;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $question03;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $question04;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $question05;

    /**
     * @ORM\Column(type="boolean")
     */
    private $display;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sellOnline;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $priceAsFrom;


    public function __construct()
    {
        $this->display = false;
        $this->priceAsFrom = true;
        $this->sellOnline = false;
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

    public function getReferenceNo(): ?string
    {
        return $this->referenceNo;
    }

    public function setReferenceNo(string $referenceNo): self
    {
        $this->referenceNo = $referenceNo;

        return $this;
    }

    public function getBriefDescription(): ?string
    {
        return $this->briefDescription;
    }

    public function setBriefDescription(?string $briefDescription): self
    {
        $this->briefDescription = $briefDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?ObjectCategory
    {
        return $this->category;
    }

    public function setCategory(?ObjectCategory $category): self
    {
        $this->category = $category;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getImage02(): ?string
    {
        return $this->image02;
    }

    public function setImage02(?string $image02): self
    {
        $this->image02 = $image02;

        return $this;
    }

    public function getImage03(): ?string
    {
        return $this->image03;
    }

    public function setImage03(?string $image03): self
    {
        $this->image03 = $image03;

        return $this;
    }

    public function getImage04(): ?string
    {
        return $this->image04;
    }

    public function setImage04(?string $image04): self
    {
        $this->image04 = $image04;

        return $this;
    }

    public function getImage05(): ?string
    {
        return $this->image05;
    }

    public function setImage05(?string $image05): self
    {
        $this->image05 = $image05;

        return $this;
    }

    public function getImage06(): ?string
    {
        return $this->image06;
    }

    public function setImage06(?string $image06): self
    {
        $this->image06 = $image06;

        return $this;
    }

    public function getImage07(): ?string
    {
        return $this->image07;
    }

    public function setImage07(?string $image07): self
    {
        $this->image07 = $image07;

        return $this;
    }

    public function getImage08(): ?string
    {
        return $this->image08;
    }

    public function setImage08(?string $image08): self
    {
        $this->image08 = $image08;

        return $this;
    }

    public function getImage09(): ?string
    {
        return $this->image09;
    }

    public function setImage09(?string $image09): self
    {
        $this->image09 = $image09;

        return $this;
    }

    public function getAttribute01(): ?string
    {
        return $this->attribute01;
    }

    public function setAttribute01(?string $attribute01): self
    {
        $this->attribute01 = $attribute01;

        return $this;
    }

    public function getAttribute01Value(): ?string
    {
        return $this->attribute01Value;
    }

    public function setAttribute01Value(?string $attribute01Value): self
    {
        $this->attribute01Value = $attribute01Value;

        return $this;
    }

    public function getAttribute02(): ?string
    {
        return $this->attribute02;
    }

    public function setAttribute02(?string $attribute02): self
    {
        $this->attribute02 = $attribute02;

        return $this;
    }

    public function getAttribute02Value(): ?string
    {
        return $this->attribute02Value;
    }

    public function setAttribute02Value(?string $attribute02Value): self
    {
        $this->attribute02Value = $attribute02Value;

        return $this;
    }

    public function getAttribute03(): ?string
    {
        return $this->attribute03;
    }

    public function setAttribute03(?string $attribute03): self
    {
        $this->attribute03 = $attribute03;

        return $this;
    }

    public function getAttribute03Value(): ?string
    {
        return $this->attribute03Value;
    }

    public function setAttribute03Value(?string $attribute03Value): self
    {
        $this->attribute03Value = $attribute03Value;

        return $this;
    }

    public function getAttribute04(): ?string
    {
        return $this->attribute04;
    }

    public function setAttribute04(?string $attribute04): self
    {
        $this->attribute04 = $attribute04;

        return $this;
    }

    public function getAttribute04Value(): ?string
    {
        return $this->attribute04Value;
    }

    public function setAttribute04Value(?string $attribute04Value): self
    {
        $this->attribute04Value = $attribute04Value;

        return $this;
    }

    public function getAttribute05(): ?string
    {
        return $this->attribute05;
    }

    public function setAttribute05(?string $attribute05): self
    {
        $this->attribute05 = $attribute05;

        return $this;
    }

    public function getAttribute05Value(): ?string
    {
        return $this->attribute05Value;
    }

    public function setAttribute05Value(?string $attribute05Value): self
    {
        $this->attribute05Value = $attribute05Value;

        return $this;
    }

    public function getQuestion01(): ?string
    {
        return $this->question01;
    }

    public function setQuestion01(?string $question01): self
    {
        $this->question01 = $question01;

        return $this;
    }

    public function getQuestion02(): ?string
    {
        return $this->question02;
    }

    public function setQuestion02(?string $question02): self
    {
        $this->question02 = $question02;

        return $this;
    }

    public function getQuestion03(): ?string
    {
        return $this->question03;
    }

    public function setQuestion03(?string $question03): self
    {
        $this->question03 = $question03;

        return $this;
    }

    public function getQuestion04(): ?string
    {
        return $this->question04;
    }

    public function setQuestion04(?string $question04): self
    {
        $this->question04 = $question04;

        return $this;
    }

    public function getQuestion05(): ?string
    {
        return $this->question05;
    }

    public function setQuestion05(?string $question05): self
    {
        $this->question05 = $question05;

        return $this;
    }

    public function getDisplay(): ?bool
    {
        return $this->display;
    }

    public function setDisplay(bool $display): self
    {
        $this->display = $display;

        return $this;
    }

    public function getSellOnline(): ?bool
    {
        return $this->sellOnline;
    }

    public function setSellOnline(bool $sellOnline): self
    {
        $this->sellOnline = $sellOnline;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceAsFrom(): ?bool
    {
        return $this->priceAsFrom;
    }

    public function setPriceAsFrom(bool $priceAsFrom): self
    {
        $this->priceAsFrom = $priceAsFrom;

        return $this;
    }
}
