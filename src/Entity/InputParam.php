<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InputParamRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=InputParamRepository::class)
 */
class InputParam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $returnMethodResult;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $originalValue;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $processedValue;

    /**
     * @ORM\ManyToOne(targetEntity=Email::class, inversedBy="inputs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsValid(): ?bool
    {
        return $this->IsValid;
    }

    public function setIsValid(bool $IsValid): self
    {
        $this->IsValid = $IsValid;
        return $this;
    }

    public function getReturnMethodResult(): ?bool
    {
        return $this->returnMethodResult;
    }

    public function setReturnMethodResult(bool $returnMethodResult): self
    {
        $this->returnMethodResult = $returnMethodResult;
        return $this;
    }

    public function getOriginalValue(): ?string
    {
        return $this->originalValue;
    }

    public function setOriginalValue(?string $originalValue): self
    {
        $this->originalValue = $originalValue;
        return $this;
    }

    public function getProcessedValue(): ?string
    {
        return $this->processedValue;
    }

    public function setProcessedValue(string $processedValue): self
    {
        $this->processedValue = $processedValue;
        return $this;
    }
}
