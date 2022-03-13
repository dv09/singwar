<?php

namespace App\Command;

use App\Constants\SignWarCommandsConstans as SWCC;
use App\Entity\Party;
use App\Managers\SignWarManagers\LookForTheStrongestManager;
use App\Managers\SignWarManagers\Sign;
use App\Managers\SignWarManagers\SignBattleManager;
use App\Managers\SignWarManagers\SignWarManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
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

//        $io->note(sprintf('You passed an argument: %s', "nada..."));

        if ($input->getOption(SWCC::TO_PLAY_OPTION)) { $io->info(SWCC::TO_PLAY_COMMENT); }
        if ($input->getOption(SWCC::TO_WIN_OPTION)) { $io->info(SWCC::TO_PLAY_COMMENT); }

        $partyOneNane = $io->ask(SWCC::PLAINTIFF_NAME, "party1");
        $partyTwoNane = $io->ask(SWCC::DEFENDANT_NAME, "party2");
        $partyOneSing = $io->ask(SWCC::TO_PLAY_PLAINTIFF_SIGN,  $input->getOption(SWCC::TO_PLAY_OPTION) ? "KVN" : "K#N");
        $partyTwoSing = $io->ask(SWCC::TO_PLAY_PLAINTIFF_SIGN, "KNN");

        $requestBody = json_encode($this->makeRequestBody($partyOneNane, $partyTwoNane, $partyOneSing, $partyTwoSing));

        if ($input->getOption(SWCC::TO_PLAY_OPTION)) $response = ($this->signBattleManager)($requestBody)->manage();
        if ($input->getOption(SWCC::TO_WIN_OPTION)) $response = ($this->lookForTheStrongestManager)($requestBody)->manage();

        $io->success(json_encode($response));

        return Command::SUCCESS;
    }




    private function makeRequestBody(string $partyOneNane, string $partyTwoNane, string $partyOneSing, string $partyTwoSing): array {
        return [
            $partyOneNane => ["rol" => "plaintiff", "sign" => $partyOneSing],
            $partyTwoNane => ["rol" => "defendant", "sign" => $partyTwoSing],
        ];
    }
}
