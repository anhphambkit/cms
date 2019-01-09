<?php

namespace Core\Base\Commands;

use Illuminate\Console\Command;
use Core\Master\Supports\PermissionCommand;
use DB;

class BuildPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lcms:build-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate framework autoload files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
    	$this->line('When you run this command, database of role system will be clean.');
    	if ($this->confirm('Do you want to continue action?')) 
    		$this->buildPermissions();
    }

    /**
     * Build list permissions
     * @author TrinhLe
     * @return mixed
     */
    protected function buildPermissions()
    {
    	$this->cleanDB();
    	$configs = config('core-base.permissions');
    	PermissionCommand::registerPermission($configs);
    }

    /**
     * Clean permissions
     * @author TrinhLe
     */
    protected function cleanDB()
    {
    	DB::table('features')->truncate();
    	DB::table('permission_flags')->truncate();
    }
}