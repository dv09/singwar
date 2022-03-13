<?php

namespace App\Managers\SignWarManagers;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Contract;
use App\Constants\SignWarManagerConstants as SWMC;

abstract class AbstractSignWarManager implements SignWarManagerInterface
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var array $requestContent */
    private $requestContent = [];

    /** @var array $signs */
    protected $signs = [];

    /** @var Contract $contract */
    protected $contract;

    /** @var EntityRepository $contractRepository */
    private $contractRepository;


    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->contractRepository = $em->getRepository(Contract::class);
    }


    /**
     * @param string $requestContent
     * @return $this
     */
    public function __invoke(string $requestContent) {
        $this->requestContent = json_decode($requestContent,true);
        return $this;
    }


    /**
     * @return Sign|null
     */
    abstract protected function play(): array;


    /**
     * @return array|array[]
     * @throws \Exception
     */
    public function manage(): array {
        $this->makeSigns();
        $winner = $this->play()[0];
        $this->makeContract();

        return ($winner instanceof Sign) ? $this->makeResponse($winner) : $this->isTied($winner);
    }


    /**
     * @return void
     */
    protected function makeContract():void {
        $contract = new Contract();
        foreach ($this->signs as $sign) {
            if($sign->getParty()->getRol() === SWMC::ROLS["PLAINTIFF"]) {
                $contract->setPlaintiff($sign->getParty());
                $contract->setPlaintiffsign($sign->getPartysign());
            }
            if($sign->getParty()->getRol() === SWMC::ROLS["DEFENDANT"]) {
                $contract->setDefendant($sign->getParty());
                $contract->setDefendantsign($sign->getPartysign());
            }
        }
        $this->contract = $this->contractRepository->add($contract);
    }


    /**
     * @return void
     * @throws \Exception
     */
    protected function makeSigns():void {
        foreach ($this->requestContent as $partyName => $partyData) {
            $partyRol='';
            $partySign='';
            foreach ($partyData as $partyDataKey => $partyDataValue ) {
                if( strtoupper($partyDataKey) === SWMC::ROL) $partyRol = $partyDataValue;
                if( strtoupper($partyDataKey) === SWMC::SIGN) $partySign = $partyDataValue;
            }

            if($partyRol === ''  || $partySign === '') throw new \Exception(SWMC::NO_RIGHT_INPUT_DATA);

            $sign = new Sign($partyName, $partyRol ,$partySign, $this->em);
            $this->signs[$sign->getParty()->getId()] = $sign;
        }
    }


    /**
     * @param Sign|null $winnerSign
     * @return array
     */
    protected function makeResponse(?Sign $winnerSign): array {
        $winner = [
            'Id' => $winnerSign->getParty()->getId(),
            'Name' => $winnerSign->getParty()->getName(),
            'Rol' => $winnerSign->getParty()->getRol(),
            'sign' => $winnerSign->getPartysign(),
            'signValue' => $winnerSign->getSignValue(),
        ];

        $contract = [
            'contractId' => $this->contract->getId(),
            'plaintiffName' => $this->contract->getPlaintiff()->getName(),
            'plaintiffSign' => $this->contract->getPlaintiffsign(),
            'defendantName' => $this->contract->getDefendant()->getName(),
            'defendantSign' => $this->contract->getDefendantsign(),
        ];

        $signatoriesInfo = [];
        foreach ($this->signs as $sign) {

            $partyLabel = $sign->getParty()->getRol() === SWMC::ROLS["DEFENDANT"] ? 'forDefendant' : 'forPlaintiff';

            $signatoryInfo = [];
            foreach ($sign->getSignatories() as $signatory) {
                $signatoryInfo[] = [
                    'Id' => $signatory->getId(),
                    'Symbol' => $signatory->getKeysign(),
                    'Name' => $signatory->getName()
                ];
            }
            $signatoriesInfo[$partyLabel] = $signatoryInfo;
        }

        return [
            'winner' => $winner,
            'contract' => $contract,
            'signatories' => $signatoriesInfo,
        ];
    }


    /**
     * @param $message
     * @return array[]
     */
    protected function isTied($message): array {
        return [
            'winner' => [
                'Id' => null,
                'Message' => $message
            ]
        ];
    }
}