<?php

namespace App\Managers\SignWarManagers;


use App\Constants\SignWarManagerConstants as SWMC;


class SignBattleManager extends AbstractSignWarManager
{
    /**
     * @return array|sign[]|null[]
     */
    protected function play(): array {
        $winnerSign = null;
        $isTied = false;

        /** @var sign $sign */
        foreach ($this->signs as $sign) {
            if(is_null($winnerSign)) $winnerSign = $sign;
            if($winnerSign !== $sign && $sign->getSignValue() > $winnerSign->getSignValue()) {
                $winnerSign = $sign;
                $isTied = false;
            }
            if($winnerSign !== $sign && $sign->getSignValue() == $winnerSign->getSignValue()) $isTied = true;
        }

        return $isTied ? [SWMC::JUDMENT_IS_TIED] : [$winnerSign];
    }
}