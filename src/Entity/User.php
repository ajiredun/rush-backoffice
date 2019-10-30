<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Enums\Roles;

/**
 * @ApiResource(
 *     accessControl="is_granted('ROLE_API_USER', object)",
 *     accessControlMessage="UNAUTHORISED_API_REQUEST",
 *     normalizationContext={"groups"={"user:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"user:write"}, "swagger_definition_name"="Write"},
 *     collectionOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"users:read"}}
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read","users:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read","users:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read","users:read"})
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write", "users:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write", "users:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "users:read"})
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $activation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read","user:write", "users:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read","user:write", "users:read"})
     */
    private $mobile;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user:read","user:write", "users:read"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read","user:write", "users:read"})
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read","user:write", "users:read"})
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user:read", "users:read"})
     */
    private $lastactive;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user:read", "users:read"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="lastModifiedBy", orphanRemoval=true)
     */
    private $pages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ApiToken", mappedBy="user", orphanRemoval=true)
     */
    private $apiTokens;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->pages = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getActivation(): ?string
    {
        return $this->activation;
    }

    public function setActivation(?string $activation): self
    {
        $this->activation = $activation;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isActiveNow()
    {
        // Delay during wich the user will be considered as still active
        $delay = new \DateTime('5 minutes ago');

        return ( $this->getLastactive() > $delay );
    }

    public function getName()
    {
        return $this->getFirstname() . " " . $this->getLastname();
    }

    /**
     * @return string
     * @Groups({"user:read", "users:read"})
     */
    public function getPicture()
    {
        return 'https://robohash.org/aj'.$this->getId().'?set=set4&size=100x100';
    }

    public function getLastactive(): ?\DateTimeInterface
    {
        return $this->lastactive;
    }

    public function setLastactive(?\DateTimeInterface $lastactive): self
    {
        $this->lastactive = $lastactive;

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
            $page->setLastModifiedBy($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getLastModifiedBy() === $this) {
                $page->setLastModifiedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ApiToken[]
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): self
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens[] = $apiToken;
            $apiToken->setUser($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): self
    {
        if ($this->apiTokens->contains($apiToken)) {
            $this->apiTokens->removeElement($apiToken);
            // set the owning side to null (unless already changed)
            if ($apiToken->getUser() === $this) {
                $apiToken->setUser(null);
            }
        }

        return $this;
    }
}
