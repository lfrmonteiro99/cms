<?php

namespace App\Entity;

use App\Repository\ContentParameterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: ContentParameterRepository::class)]
class ContentParameter
{
    public const TYPES = [
        'select' => 1,
        'text' => 2,
        'radio_button' => 3
    ];
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'contentParameters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Content $content_id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deleted_at = null;

    #[ORM\Column(length: 255)]
    private string $section_type = '';

    #[ORM\OneToMany(mappedBy: 'contentParameter',cascade:["persist"], targetEntity: ParameterValue::class)]
    private Collection $parameterValues;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->parameterValues = new ArrayCollection();
    }

    public function getSectionType()
    {
        return $this->section_type;
    }

    public function setSectionType($section_type)
    {
        $this->section_type = $section_type;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContentId(): ?Content
    {
        return $this->content_id;
    }

    public function setContentId(?Content $content_id): self
    {
        $this->content_id = $content_id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at = null): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection<int, ParameterValue>
     */
    public function getParameterValues(): Collection
    {
        return $this->parameterValues;
    }

    public function addParameterValue(ParameterValue $parameterValue): self
    {
        if (!$this->parameterValues->contains($parameterValue)) {
            $this->parameterValues->add($parameterValue);
            $parameterValue->setContentParameter($this);
        }

        return $this;
    }

    public function removeParameterValue(ParameterValue $parameterValue): self
    {
        if ($this->parameterValues->removeElement($parameterValue)) {
            // set the owning side to null (unless already changed)
            if ($parameterValue->getContentParameter() === $this) {
                $parameterValue->setContentParameter(null);
            }
        }

        return $this;
    }
}
