<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;

class DatabaseMigrationCommand extends Command
{

    protected static $defaultName = "db:migrate";

    public function __construct()
    {
        $this->migrationPath = dirname(__DIR__) . '/migrations/';
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("used to run migrations")
            ->setHelp("Command used to run migration");
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_runMigrations($output);
    }

    public function _runMigrations($output)
    {
        $migrations = glob($this->migrationPath . '*.php');

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);
            $filename = $file['filename'];

            if ($filename !== "Schema"):
                $className = '\App\Migrations\\' . Str::studly(\substr($filename, 15));
                $class = new $className;
                $class->up();

                $output->writeln('db migration on => ' . str_replace(dirname(__DIR__) . '/migrations/', "", $migration));
            endif;
        }
    }
}