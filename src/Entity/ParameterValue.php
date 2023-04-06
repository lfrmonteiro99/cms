<?php

namespace App\Entity;

use App\Repository\ParameterValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterValueRepository::class)]
class ParameterValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'parameterValues')]
    #[ORM\JoinColumn(nullable: false)]

    private ?ContentParameter $contentParameter = null;

    #[ORM\Column]
    private $value = '';

    #[ORM\Column(length: 255)]
    private ?string $sectionParameterType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentParameter(): ?ContentParameter
    {
        return $this->contentParameter;
    }

    public function setContentParameter(?ContentParameter $contentParameter): self
    {
        $this->contentParameter = $contentParameter;

        return $this;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSectionParameterType(): ?string
    {
        return $this->sectionParameterType;
    }

    public function setSectionParameterType(string $sectionParameterType): self
    {
        $this->sectionParameterType = $sectionParameterType;

        return $this;
    }
}
