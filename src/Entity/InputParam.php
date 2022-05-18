<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use App\Repository\InputParamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"InputParam:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"InputParam:write"}, "swagger_definition_name"="Write"},
 *     itemOperations={
 *        "post"={"method"="POST", "route_name"="input_param_add"},
 *        "put",
 *        "delete"={"method"="DELETE", "route_name"="input_param_delete"}
 *     },
 *     collectionOperations={
 *         "post"={"method"="POST", "route_name"="input_param_add_many"},
 *         "delete"={"method"="DELETE", "route_name"="input_param_delete_many"}
 *      }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isValid"})
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
     * @ORM\Column(type="boolean", nullable=true, options={"default":true})
     */
    private $isValid;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $returnMethodResult;

    /**
     * @ORM\Column(type="string", nullable=false, length=1024)
     * @Groups({"InputParam:write"})
     */
    private $originalValue;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true, options={"default":""})
     * @Groups({"InputParam:read", "Email:read"})
     */
    private $processedValue;

    /**
     * @ORM\ManyToOne(targetEntity=Email::class, inversedBy="inputs")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"InputParam:read", "Email:read", "Email:write"})
     */
    private $email;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool|null
     */
    public function getIsValid(): ?bool
    {
        return $this->IsValid;
    }

    /**
     * @param bool $IsValid
     * @return $this
     */
    public function setIsValid(bool $IsValid): self
    {
        $this->IsValid = $IsValid;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getReturnMethodResult(): ?bool
    {
        return $this->returnMethodResult;
    }

    /**
     * @param bool $returnMethodResult
     * @return $this
     */
    public function setReturnMethodResult(bool $returnMethodResult): self
    {
        $this->returnMethodResult = $returnMethodResult;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginalValue(): ?string
    {
        return $this->originalValue;
    }

    /**
     * @param string|null $originalValue
     * @return $this
     */
    public function setOriginalValue(?string $originalValue): self
    {
        $this->originalValue = $originalValue;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProcessedValue(): ?string
    {
        return $this->processedValue;
    }

    /**
     * @param string $processedValue
     * @return $this
     */
    public function setProcessedValue(string $processedValue): self
    {
        $this->processedValue = $processedValue;
        return $this;
    }
}
