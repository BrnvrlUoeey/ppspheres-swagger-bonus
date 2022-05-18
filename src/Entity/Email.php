<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\InputParam;
use App\Repository\EmailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"Email:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"Email:write"}, "swagger_definition_name"="Write"},
 *     itemOperations={"get"},
 *     collectionOperations={},
 *     attributes={"formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}}
 * )
 * @ORM\Entity(repositoryClass=EmailRepository::class)
 */
class Email
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=InputParam::class, mappedBy="email", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"Email:read", "Email:write", "InputParam:write"})
     */
    private $inputs;

    /**
     * @ORM\OneToOne(targetEntity=Expression::class, mappedBy="email", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"Email:read", "Email:write", "Expression:write"})
     */
    private $expression;

    public function __construct()
    {
        $this->inputs = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|InputParam[]
     */
    public function getInputs(): Collection
    {
        return $this->inputs;
    }

    /**
     * @param \App\Entity\InputParam $input
     * @return $this
     */
    public function addInput(InputParam $input): self
    {
        if (!$this->inputs->contains($input)) {
            $this->inputs[] = $input;
            $input->setExpression($this);
        }
        return $this;
    }

    /**
     * @param \App\Entity\InputParam $input
     * @return $this
     */
    public function removeInput(InputParam $input): self
    {
        if ($this->inputs->contains($input)) {
            $this->inputs->removeElement($input);
            // set the owning side to null (unless already changed)
            if ($input->getExpression() === $this) {
                $input->setExpression(null);
            }
        }
        return $this;
    }

    /**
     * @return Expression|null
     */
    public function getExpression(): ?Expression
    {
        return $this->expression;
    }

    /**
     * @param Expression $expression
     * @return $this
     */
    public function setExpression(Expression $expression): self
    {
        $this->expression = $expression;

         return $this;
    }

    /**
     * Evaluate $this->expression with given input params
     */
    public function evaluateExpression()
    {

    }



}
