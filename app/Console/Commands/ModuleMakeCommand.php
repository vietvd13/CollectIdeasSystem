<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;


class ModuleMakeCommand extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model repository';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $repositoryClass;

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $model;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle(){
        var_dump(app_path());
        $this->setRepositoryClass();

        $path = $this->getPath($this->repositoryClass);
        if ($this->alreadyExists($this->getNameInput().'Repository')) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($this->repositoryClass));

        $this->info($this->type.' created successfully.');

        $this->line("<info>Created Repository :</info> $this->repositoryClass");

        //if ($this->option('interface')) {
            $this->createRepositoryInterface();
        //}

        $repositoryName= Str::studly(class_basename($this->argument('name')));
        $this->call('make:controllers', ['name' => "{$repositoryName}"]);
        $this->call('make:models', ['name' => "{$repositoryName}"]);
        $this->call('make:requests', ['name' => "{$repositoryName}"]);
        $this->call('make:resources', ['name' => "{$repositoryName}"]);
        $this->call('make:migration', ['name' => "create{$repositoryName}s_table"]);
    }

    protected function createRepositoryInterface()
    {
        $repositoryName= Str::studly(class_basename($this->argument('name')));

        $this->call('make:interface', [
            'name' => "{$repositoryName}RepositoryInterface",
        ]);
    }



    /**
     * Set repository class name
     *
     * @return  void
     */
    private function setRepositoryClass()
    {
        $name = $this->argument('name');
        $this->model = $name;
        $modelClass = $this->qualifyClass($name);
        $this->repositoryClass = $modelClass . 'Repository';
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if(!$this->argument('name')){
            throw new InvalidArgumentException("Missing required argument model name");
        }

        $stub = parent::replaceClass($stub, $name);
        $stub = str_replace('DummyModel', $this->model, $stub);
        $mytime = Carbon::now();
        $stub = str_replace('DummyDate', $mytime->toDateString(), $stub);

        return $stub;
    }

    /**
     *
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return app_path() . '\Console\stubs\repository.stub';
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model class.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the repository already exists.'],
            ['interface', 'i', InputOption::VALUE_NONE, 'Create a new interface for the repository.'],
        ];
    }
}
