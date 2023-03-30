<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'content_id', targetEntity: ContentParameter::class)]
    private Collection $contentParameters;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->contentParameters = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, ContentParameter>
     */
    public function getContentParameters(): Collection
    {
        return $this->contentParameters;
    }

    public function addContentParameter(ContentParameter $contentParameter): self
    {
        if (!$this->contentParameters->contains($contentParameter)) {
            $this->contentParameters->add($contentParameter);
            $contentParameter->setContentId($this);
        }

        return $this;
    }

    public function removeContentParameter(ContentParameter $contentParameter): self
    {
        if ($this->contentParameters->removeElement($contentParameter)) {
            // set the owning side to null (unless already changed)
            if ($contentParameter->getContentId() === $this) {
                $contentParameter->setContentId(null);
            }
        }

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
}
