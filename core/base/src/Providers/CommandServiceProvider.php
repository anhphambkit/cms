<?php
namespace Core\Base\Providers;
use Illuminate\Support\ServiceProvider;
use Core\Base\Commands\DumpAutoload;
use Core\Base\Commands\PluginCreateCommand;

class CommandServiceProvider extends ServiceProvider
{
	/**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

	/**
	 * Boot containers
	 * @author TrinhLe
	 */
	public function boot()
	{
		$listPackages = getPsr4Packages();

		$basePathKernel = "/Commands/Kernel.php";
		$baseNamspace   = "Commands\\Kernel";

		$listCommands = array();

		foreach ($listPackages as $namespace => $packageUrl) {

			$fullPathKernel = "{$packageUrl}{$basePathKernel}";
			$fullNamespace = "\\{$namespace}{$baseNamspace}";

			if(file_exists(base_path($fullPathKernel)))
			{	
				$packageCommands = app("$fullNamespace")->getCommands();
				$listCommands = array_merge($listCommands, $packageCommands);
			}
		}

		return $this->commands($listCommands);
	}
}