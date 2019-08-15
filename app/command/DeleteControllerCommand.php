<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;
use App\Command\BaseCommand;

class DeleteControllerCommand extends Command
{

    protected static $defaultName = "d:controller";

    public function __construct()
    {
        $this->controllerPath = dirname(__DIR__) . '/controllers/';
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("used to delete a controller")
            ->setHelp("Command used to delete a controller")
            ->addArgument("controller", InputArgument::REQUIRED, "controller name");
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->_deleteController($input));
    }

    public function _deleteController($input)
    {
        list($dirname, $filename) = BaseCommand::dir_and_file($input);

        if(file_exists($dirname . '/' . $filename)):
            unlink($dirname . '/' . $filename);

            $is_empty = !(new \FilesystemIterator($dirname))->valid();

            if ($is_empty === true):
                $path = explode('/', $dirname);
                $base_controller = Str::studly(strtolower(end($path))) . "Controller.php";
                $base_path = str_replace(end($path), "", $dirname);

                unlink($base_path . $base_controller);
                rmdir($dirname);
            endif;
        else:
            return "Controller does not exists";
        endif;

        return "{$filename} controller deleted successfully";
    }
}