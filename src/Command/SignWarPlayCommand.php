<?php

namespace App\Command;

use App\Constants\SignWarCommandsConstans as SWCC;
use App\Managers\SignWarManagers\LookForTheStrongestManager;
use App\Managers\SignWarManagers\SignBattleManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class SignWarPlayCommand extends Command
{
    private $signBattleManager;
    private $lookForTheStrongestManager;

    public function __construct(SignBattleManager $signBattleManager, LookForTheStrongestManager $lookForTheStrongestManager)
    {
        $this->signBattleManager = $signBattleManager;
        $this->lookForTheStrongestManager = $lookForTheStrongestManager;

        parent::__construct(null);
    }


    protected function configure(): void
    {
        $this->setName("signwar:play")
             ->setHelp(SWCC::PLAY_DESCRIPTION)
             ->addOption(SWCC::TO_PLAY_OPTION, null, InputOption::VALUE_NONE, SWCC::TO_PLAY_INFO)
             ->addOption(SWCC::TO_WIN_OPTION, null, InputOption::VALUE_NONE, SWCC::TO_WIN_INFO);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $option = '';
        if ($input->getOption(SWCC::TO_PLAY_OPTION)) {
            $option = SWCC::TO_PLAY_OPTION;
            $plaintiffAskComment = SWCC::TO_PLAY_PLAINTIFF_SIGN;
            $defendantAskComment = SWCC::TO_PLAY_PLAINTIFF_SIGN;
        }
        if ($input->getOption(SWCC::TO_WIN_OPTION)) {
            $option = SWCC::TO_WIN_OPTION;
            $plaintiffAskComment = SWCC::TO_WIN_PLAINTIFF_SIGN;
            $defendantAskComment = SWCC::TO_WIN_PLAINTIFF_SIGN;
        }

        $io->info(SWCC::TO_PLAY_COMMENT);
        $partyOneNane = $io->ask(SWCC::PLAINTIFF_NAME, "party1");
        $partyOneSing = $io->ask($plaintiffAskComment,  $input->getOption(SWCC::TO_PLAY_OPTION) ? "KVN" : "K#N");
        $partyTwoNane = $io->ask(SWCC::DEFENDANT_NAME, "party2");
        $partyTwoSing = $io->ask($defendantAskComment, "KNN");

        $requestBody = json_encode($this->makeRequestBody($partyOneNane, $partyTwoNane, $partyOneSing, $partyTwoSing));

        if ($input->getOption(SWCC::TO_PLAY_OPTION)) $response = ($this->signBattleManager)($requestBody)->manage();
        if ($input->getOption(SWCC::TO_WIN_OPTION)) $response = ($this->lookForTheStrongestManager)($requestBody)->manage();

        $response = $this->makeResponse($response, $option);

        $io->success(json_encode($response));

        return Command::SUCCESS;
    }


    private function makeResponse(array $response, string $option): string {
        if(!isset($response['winner']['message'])) {

            $responseString = "The Winner is:" . $response['winner']['name'] . "(" . $response['winner']['rol'] . ")" . "with " . $response['winner']['signValue'] . " points. ";

            if ($option == SWCC::TO_WIN_OPTION) {
                $responseString .= "And the complete signature is " . $response['winner']['sign'];
            }
            return $responseString;
        }

        return $response['winner']['message'];
    }


    private function makeRequestBody(string $partyOneNane, string $partyTwoNane, string $partyOneSing, string $partyTwoSing): array {
        return [
            $partyOneNane => ["rol" => "plaintiff", "sign" => $partyOneSing],
            $partyTwoNane => ["rol" => "defendant", "sign" => $partyTwoSing],
        ];
    }
}
