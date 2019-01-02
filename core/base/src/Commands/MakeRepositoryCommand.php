<?php
namespace Packages\Core\Commands;
use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name : The module that you want to create} {repo} {--P|plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Eden] Make new repo.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() 
    {
        $coreNamespace = $this->option('plugin') ? 'Plugins' : 'Core';
        $basePath      = $this->option('plugin') ? config('core-base.cms.plugin_path') : config('core-base.cms.core_path');
        $repo = $this->argument('repo');

        $this->plugin = ucfirst(strtolower($this->argument('name')));
        $this->location = $basePath . '/' . strtolower($this->plugin);

        $fromStub = base_path('core/base/stubs/repository');

        $this->dataTranslate = [
            "{CoreNamespace}" => $coreNamespace,
            "{Repo}" => studly_case($repo),
            "{Package}" => studly_case($this->plugin),
        ];

        $this->filenameTranslate = [
            "{Repo}" => studly_case($repo),
            ".stub" => ".php",
        ];
        
        $this->publishStubs($fromStub);
        $this->renameFileName($this->location);
        $this->searchAndReplaceInFiles();



        $this->line('------------------');
        $this->line('<info>The plugin repository</info> <comment>' . studly_case($this->plugin) . '</comment> <info>was created in</info> <comment>' . $this->location . '</comment><info>, customize it!</info>');
        $this->line('------------------');


        if ($this->confirm('Do you want to bind repo with interface?')) {
            return $this->call("make:bind-repo",['package' => $package, 'repo' => $repo]);
        }
    }
}