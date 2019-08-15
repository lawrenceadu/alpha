<?php
    namespace App\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Process\Process;
    use Symfony\Component\Process\Exception\ProcessFailedException;
    use Illuminate\Support\Str;

    class GenerateModelCommand extends Command
    {
        // the name of the command (the part after "bin/console")
        protected static $defaultName = 'g:model';

        public function __construct()
        {
            $this->migrationPath = dirname(__DIR__) . "/migrations/";
            $this->modelPath     = dirname(__DIR__). "/models/";
            
            parent::__construct();
        }
    
        protected function configure()
        {
            $this 
                ->setDescription("A command used to create model")
                ->setHelp("This command is used to create model files")
                ->addArgument('model', InputArgument::REQUIRED, 'model file name');
        }
    
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            // create the model file
            $model = $this->modelPath . Str::singular(Str::studly($input->getArgument("model"))) . '.php';

            if (!file_exists($model)):
                $model = $this->_createModel($input);
                $output->writeln($model . ' model generated');

                $migration = $this->_createMigration($input);
                $output->writeln($migration . ' file generated');

                $process = new Process("composer dump-autoload");
                $process->run();

                $output->writeln($process->getOutput());
            else:
                $output->writeln("Model already exists");
            endif;
        }

        public function _createModel($input): String
        {
            $model = Str::singular(Str::studly($input->getArgument("model")));

            // get content of the migration stub
            $fileContent = \file_get_contents(__DIR__ . '/stubs/model.stub');

            // replace all ClassName with model variable
            $fileContent = str_replace("ClassName", $model, $fileContent);
            
            // update the model file
            file_put_contents($this->modelPath . "{$model}.php", $fileContent);

            return $model;
        }

        public function _createMigration($input)
        {
            $model = $input->getArgument("model");

            $filename = Str::snake(Str::plural($model));
            $file = $this->migrationPath . date("YmdHis") . '_create_' . $filename . '.php';

            // create the migration file
            touch($file);

            $className = 'Create' . Str::studly($filename);
            $tableName = \strtolower(Str::plural($model));

            // get content of the migration stub
            $fileContent = \file_get_contents(__DIR__ . '/stubs/create.stub');

            // replace all ClassName with className variable
            $fileContent = str_replace(["ClassName", "tableName"], [$className, "{$tableName}"], $fileContent);
            // update the migration file
            file_put_contents($file, $fileContent);

            return $file;
        }
    }