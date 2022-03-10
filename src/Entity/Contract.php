<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractRepository::class)
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Party::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $plaintiff;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $plaintiffsign;

    /**
     * @ORM\ManyToOne(targetEntity=Party::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $defendant;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $defendantsign;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaintiff(): ?Party
    {
        return $this->plaintiff;
    }

    public function setPlaintiff(?Party $plaintiff): self
    {
        $this->plaintiff = $plaintiff;

        return $this;
    }

    public function getPlaintiffsign(): ?string
    {
        return $this->plaintiffsign;
    }

    public function setPlaintiffsign(string $plaintiffsign): self
    {
        $this->plaintiffsign = $plaintiffsign;

        return $this;
    }

    public function getDefendant(): ?Party
    {
        return $this->defendant;
    }

    public function setDefendant(?Party $defendant): self
    {
        $this->defendant = $defendant;

        return $this;
    }

    public function getDefendantsign(): ?string
    {
        return $this->defendantsign;
    }

    public function setDefendantsign(string $defendantsign): self
    {
        $this->defendantsign = $defendantsign;

        return $this;
    }
}
