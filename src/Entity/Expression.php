<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExpressionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"Expression:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"Expression:write"}, "swagger_definition_name"="Write"},
 *     itemOperations={
 *        "post"={"method"="POST", "route_name"="expression_add"},
 *        "put",
 *        "delete"={"method"="DELETE", "route_name"="expression_delete"}
 *     },
 *     collectionOperations={
 *        "post"={"method"="POST", "route_name"="expression_add_many"},
 *        "delete"={"method"="DELETE", "route_name"="expression_delete_many"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=ExpressionRepository::class)
 */
class Expression
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5096)
     * @Groups({"Expression:read", "Expression:write", "Email:read"})
     */
    private $text;

    /**
     * @ORM\OneToOne(targetEntity=Email::class, inversedBy="expression")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"Expression:read", "Email:read", "Email:write"})
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
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @Groups({"Expression:write"})
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Email|null
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     * @return $this
     */
    public function setEmail(Email $email): self
    {
        $this->email = $email;

        // set the owning side of the relation if necessary
        if ($email->getExpression() !== $this) {
            $email->setExpression($this);
        }
        return $this;
    }
}
