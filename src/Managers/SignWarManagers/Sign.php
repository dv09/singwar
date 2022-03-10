<?php

namespace App\Managers\SignWarManagers;

use App\Entity\Actor;
use App\Entity\Party;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Constants\SignWarManagerConstants as SWMC;


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


    /**
     * @param string $partyName
     * @param string $partyRol
     * @param string $partysign
     * @param EntityManagerInterface $em
     * @throws \Exception
     */
    public function __construct(string $partyName, string $partyRol ,string $partySign, EntityManagerInterface $em) {
        $this->partyRepository = $em->getRepository(Party::class);
        $this->actorRepository = $em->getRepository(Actor::class);
        $this->partysign = $partySign;
        $this->setParty($partyName, $partyRol);
        $this->setSignatories();
        $this->setSignValue();
    }


    /**
     * @param string $partyName
     * @param string $partyRol
     * @return void
     * @throws \Exception
     */
    private function setParty(string $partyName, string $partyRol):void {
        try {
            $this->party = $this->partyRepository->findOrAdd($partyName, $partyRol);

        } catch (\Exception $e) {
            throw new \Exception(SWMC::PARTY_DATA_LOAD_ERROR . ": $partyName , mensaje: " . $e->getMessage());
        }
    }


    /**
     * @return void
     * @throws \Exception
     */
    private function setSignatories():void {
        try {
            $partysignDigits = str_split(strtoupper($this->partysign));
            if(count($partysignDigits)>3) throw new \Exception(SWMC::MAX_SIGN_LENGTH);

            foreach ($partysignDigits as $signDigit) {
                if($signDigit !== "#") {
                    $signator = $this->actorRepository->findOneBy(['keySign' => $signDigit]);
                    if(is_null($signator)) throw new \Exception(SWMC::NO_REG_SIGNER . ": \"$signDigit\" ");
                    $this->signatories[] = $signator;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception(SWMC::SIGN_VALIDATION_ERROR . ": $this->partysign, mensaje: " . $e->getMessage());
        }
    }


    /**
     * @return void
     */
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


    /**
     * @param string $newPartySign
     * @return $this
     * @throws \Exception
     */
    public function resetSignValue(string $newPartySign): Sign{
        $this->signValue = 0;
        $this->signatories = [];
        $this->partysign = $newPartySign;
        $this->setSignatories();
        $this->setSignValue();
        return $this;
    }


    /**
     * @return Party
     */
    public function getParty(): Party {
        return $this->party;
    }


    /**
     * @return array
     */
    public function getSignatories():array  {
        return $this->signatories;
    }


    /**
     * @return int
     */
    public function getSignValue():int {
        return $this->signValue;
    }


    /**
     * @return string
     */
    public function getPartySign():string {
        return $this->partysign;
    }
}