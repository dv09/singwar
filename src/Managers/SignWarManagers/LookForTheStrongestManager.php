<?php

namespace App\Managers\SignWarManagers;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Constants\SignWarManagerConstants as SWMC;


class LookForTheStrongestManager extends AbstractSignWarManager
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ActorRepository $actorRepository */
    private $actorRepository;


    public function __construct(EntityManagerInterface $em) {
        parent::__construct($em);
        $this->em = $em;
        $this->actorRepository = $em->getRepository(Actor::class);
    }


    protected function play(): array {
        /** @var Sign $futureWinnerSign */
        [   'futureLoserSign' => $futureLoserSign,
            'futureWinnerSign' => $futureWinnerSign
        ] = $this->clasifySign();

        $actorToSign = null;
        $message = '';
        $advantage = $futureLoserSign->getSignValue() - $futureWinnerSign->getSignValue();

        if($advantage < 0 ) $message = SWMC::ALREADY_WINNER;
        if($advantage >= 5)  $message = SWMC::NEVER_WINNER;
        if($advantage >= 0  &&  $advantage < 5) $actorToSign = $this->getActorToWin($futureWinnerSign, $advantage);

        return is_null($actorToSign)
            ? [$message]
            : [$futureWinnerSign->resetSignValue($this->getWinnerDigits($futureWinnerSign, $actorToSign))];
    }


    private function clasifySign(): array {
        try {
            $futureLoserSign = null;
            $futureWinnerSign = null;

            /** @var sign $sign */
            foreach ($this->signs as $sign) {
                if (substr_count($sign->getPartySign(),"#") == 0) $futureLoserSign = $sign;
                if (substr_count($sign->getPartySign(),"#") == 1) $futureWinnerSign = $sign;
            }

            if (is_null($futureLoserSign)) throw new Exception(SWMC::ONLY_ONE_QUAD_SIGN);
            if (is_null($futureWinnerSign)) throw new Exception(SWMC::ONLY_ONE_QUAD);

        } catch (Exception $e) {
            throw new Exception(SWMC::NO_RIGHT_VALIDATED_SIGN . $e->getMessage());
        }

        return ['futureLoserSign' => $futureLoserSign, 'futureWinnerSign' => $futureWinnerSign];
    }


    private function getActorToWin(Sign $futureWinnerSign, int $advantage): ?Actor {
        /* Compensación V vs K no tiene valor */
        /* Con una K en la firma ganadora y ventaja 0 devolverá una V(aporta 0) -> incrementar la ventaja devolverá una N*/
        if(strpos($futureWinnerSign->getPartySign(),'K') !== false && $advantage == 0) $advantage = 1;

        $actors = $this->actorRepository->findNextToWin($advantage);

        $candidate = null;
        foreach ($actors as $actor) {
            if(is_null($candidate)) $candidate = $actor;
            if($candidate !== $actor && $actor->getValueSign() < $candidate->getValueSign()) $candidate = $actor;
        }

        return $candidate;
    }


    private function getWinnerDigits(Sign $futureWinnerSign, Actor $actorToSign): string {
        return  substr_replace(
            $futureWinnerSign->getPartySign(),
            $actorToSign->getKeySign(),
            strpos($futureWinnerSign->getPartySign(),'#') ,
            1
        );
    }
}