<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EmailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ApiResource()
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
     * @ORM\OneToMany(targetEntity=InputParam::class, mappedBy="expression", orphanRemoval=true)
     */
    private $inputs;

    /**
     * @ORM\Column(type="string", length=5096)
     */
    private $expression;

    public function __construct()
    {
        $this->inputs = new ArrayCollection();
    }

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

    public function addInput(InputParam $input): self
    {
        if (!$this->inputs->contains($input)) {
            $this->inputs[] = $input;
            $input->setExpression($this);
        }
        return $this;
    }

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

    public function getExpression(): ?string
    {
        return $this->expression;
    }

    public function setExpression(string $expression): self
    {
        $this->expression = $expression;
        return $this;
    }

    /*
     * Evaluate $this->expression with given input params
     */
    public function evaluateExpression()
    {

    }

}
