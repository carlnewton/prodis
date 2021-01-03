<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 */
class Link
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Flow::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $flow;

    /**
     * @ORM\ManyToOne(targetEntity=Step::class, inversedBy="links")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $parentStep;

    /**
     * @ORM\ManyToOne(targetEntity=Step::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $step;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFlow(): ?Flow
    {
        return $this->flow;
    }

    public function setFlow(?Flow $flow): self
    {
        $this->flow = $flow;

        return $this;
    }

    public function getParentStep(): ?Step
    {
        return $this->parentStep;
    }

    public function setParentStep(?Step $parentStep): self
    {
        $this->parentStep = $parentStep;

        return $this;
    }

    public function getStep(): ?Step
    {
        return $this->step;
    }

    public function setStep(?Step $step): self
    {
        $this->step = $step;

        return $this;
    }
}
