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
    private $keySign;

    /**
     * @ORM\Column(type="integer")
     */
    private $valueSign;

    /**
     * @ORM\Column(type="string", length=1 ,nullable="true")
     */
    private $nullTo;

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

    public function getKeySign(): ?string
    {
        return $this->keySign;
    }

    public function setKeySign(string $keySign): self
    {
        $this->keySign = $keySign;

        return $this;
    }

    public function getValueSign(): ?int
    {
        return $this->valueSign;
    }

    public function setValueSign(int $valueSign): self
    {
        $this->valueSign = $valueSign;

        return $this;
    }

    public function getNullTo(): ?string
    {
        return $this->nullTo;
    }

    public function setNullTo(string $nullTo): self
    {
        $this->nullTo = $nullTo;

        return $this;
    }
}
