<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Excçeption\ProcessFailedException;
use Illuminate\Support\Str;
use App\Command\BaseCommand;

class GenerateControllerCommand extends Command
{
    protected static $defaultName = 'g:controller';

    public function __construct(){
        $this->controllerPath = dirname(__DIR__) . '/controllers/';
        $this->baseController = "Base";
        parent::__construct();
    }

    protected function configure()
    {
        $this 
            ->setDescription("command to generate controller file")
            ->setHelp("Used to generate controller file")
            ->addArgument("controller", InputArgument::REQUIRED, 'controller name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->_generateController($input));

        $process = new Process("composer dump-autoload");
        $process->run();
        $output->writeln($process->getOutput());
    }

    public function _generateController($input)
    {
        list($dirname, $filename) = BaseCommand::dir_and_file($input);

        if(!file_exists($dirname)):
            // check directory if not exists
            mkdir($dirname, 0755, true);

            $paths = explode('/', $dirname);
            $this->baseController = Str::studly((strtolower(end($paths))));
            $child_path = end($paths);

            $base_path = str_replace($child_path, "", $dirname);

            if(!file_exists($base_path . $this->baseController . 'Controller.php')):
                $file = $base_path . $this->baseController . 'Controller.php';
                // create base controller
                touch($file);

                $fileContent = file_get_contents(__DIR__ . '/stubs/controller.stub');
                $fileContent = str_replace("ClassName", $this->baseController, $fileContent);
                file_put_contents($file, $fileContent);
            endif;
        endif;

        if (!file_exists($dirname . '/' . $filename)):
            $file = $dirname . '/' . $filename;
            $controller = Str::studly(str_replace("Controller.php", "", $filename));
            // create the main controller file
            touch($file);  

            $fileContent = file_get_contents(__DIR__ . '/stubs/subController.stub');
            $fileContent = str_replace(["ClassName", "BaseController"], [$controller, $this->baseController], $fileContent);
            file_put_contents($file, $fileContent);

            return "Controller created successfully";
        else:
            return "Controller already exists";
        endif;
    }
}