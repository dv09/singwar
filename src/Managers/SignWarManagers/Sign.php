<?php

namespace App\Managers\SignWarManagers;

use App\Entity\Actor;
use App\Entity\Party;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


class Sign
{
    /** @var Party $party */
    private $party;

    /** @var string $partysign */
    private $partysign;

    /** @var array $signatories */
    private $signatories;

    /** @var int $signValue */
    private $signValue = 0;

    /** @var EntityRepository $partyRepository */
    private $partyRepository;

    /** @var EntityRepository $actorRepository */
    private $actorRepository;


    public function __construct(string $partyName, string $partyRol ,string $partysign, EntityManagerInterface $em) {
        $this->partyRepository = $em->getRepository(Party::class);
        $this->actorRepository = $em->getRepository(Actor::class);
        $this->partysign = $partysign;
        $this->setParty($partyName, $partyRol);
        $this->setSignatories();
        $this->setSignValue();
    }


    private function setParty(string $partyName, string $partyRol):void {
        try {
            $this->party = $this->partyRepository->findOrAdd($partyName, $partyRol);

        } catch (\Exception $e) {
            throw new \Exception("Error al cargar datos de la parte: $partyName , mensaje: " . $e->getMessage());
        }
    }


    private function setSignatories():void {
        try {
            $partysignDigits = str_split(strtoupper($this->partysign));
            if(count($partysignDigits)>3) throw new \Exception('El número de dígitos de la firma no puede exceder los 3 dígitos');

            foreach ($partysignDigits as $signDigit) {
                if($signDigit !== "#") {
                    $signator = $this->actorRepository->findOneBy(['keySign' => $signDigit]);
                    if(is_null($signator)) throw new \Exception("Firmante no registrado: \"$signDigit\" ");
                    $this->signatories[] = $signator;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Error en validación de la firma: $this->partysign, mensaje: " . $e->getMessage());
        }
    }


    private function setSignValue():void {
        $nulledsigns = [];

        /** @var Actor $signator */
        foreach ($this->signatories as $signator) {
            if(!is_null($signator->getNullTo())) $nulledsigns[] = $signator->getNullTo();
        }

        foreach ($this->signatories as $signator) {
          if(!in_array($signator->getKeysign(), $nulledsigns)) $this->signValue += $signator->getValuesign();
        }
    }


    public function resetSignValue(string $newPartySign): Sign{
        $this->signValue = 0;
        $this->signatories = [];
        $this->partysign = $newPartySign;
        $this->setSignatories();
        $this->setSignValue();
        return $this;
    }


    public function getParty(): Party {
        return $this->party;
    }


    public function getSignatories():array  {
        return $this->signatories;
    }


    public function getSignValue():int {
        return $this->signValue;
    }


    public function getPartySign():string {
        return $this->partysign;
    }
}