<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    public const PARAMETER_TYPES = [
        'text' => 1,
        'select' => 2,
        'number' => 3
    ];

    public const SECTION_TYPES = [
        'heading' => 1,
        'content' => 2
    ];

    public const SECTION_PARAMETERS_TYPES = [
        self::SECTION_TYPES['heading'] => [
            self::PARAMETER_TYPES['text'],
            self::PARAMETER_TYPES['number']
        ],
        self::SECTION_TYPES['content'] => [
            self::PARAMETER_TYPES['text']
        ],
    ];

    public const TEMPLATES = [
        'MyResume' => 1,
        'iPortfolio' => 2,
        'Arsha' => 3,
        'Base' => 4
    ];
    
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $template = 'base';

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

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtAutomatically()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }
}
