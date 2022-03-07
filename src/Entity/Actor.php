<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActorRepository::class)
 */
class Actor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $keySing;

    /**
     * @ORM\Column(type="integer")
     */
    private $valueSing;

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

    public function getKeySing(): ?string
    {
        return $this->keySing;
    }

    public function setKeySing(string $keySing): self
    {
        $this->keySing = $keySing;

        return $this;
    }

    public function getValueSing(): ?int
    {
        return $this->valueSing;
    }

    public function setValueSing(int $valueSing): self
    {
        $this->valueSing = $valueSing;

        return $this;
    }
}
