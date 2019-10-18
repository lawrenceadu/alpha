<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psy\Shell;

class ConsoleCommand extends Command
{

    protected static $defaultName = "console";

    protected function configure()
    {
        $this
            ->setDescription("used to run alpha console")
            ->setHelp("Command used to run alpha console");
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Alpha interactive shell activated:");
        $shell = new Shell();
        $output->write($shell->run());
    }
}