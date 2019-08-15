<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;

class GenerateHelperCommand extends Command
{
    protected static $defaultName = 'g:helper';

    public function __construct(){
        $this->helperPath = dirname(__DIR__) . '/helpers/';
        parent::__construct();
    }

    protected function configure()
    {
        $this 
            ->setDescription("command to generate helper file")
            ->setHelp("Used to generate helper file")
            ->addArgument("helper", InputArgument::REQUIRED, 'helper name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = Str::studly($input->getArgument("helper").'Helper');

        $file = $this->helperPath . $helper . '.php';

        touch($file);

        $fileContent = \file_get_contents(__DIR__ . '/stubs/helper.stub');
        $fileContent = str_replace('ClassName', $helper, $fileContent);
        \file_put_contents($file, $fileContent);

        $output->writeln($helper . ' generated successfully');

        $process = new Process("composer dump-autoload");
        $process->run();

        $output->writeln($process->getOutput());
    }
}