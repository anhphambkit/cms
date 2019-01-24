<?php

namespace Core\Base\Commands;

class Kernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        DumpAutoload::class,
        
        MakeRepositoryCommand::class,
        MakeBindContentRepository::class,
        MigrateSystemCommand::class,

        PublishConfig::class,
        PublishData::class,

        BuildPermissions::class,
        RebuildPermissionsCommand::class,

        PluginCreateCommand::class,
        PluginActivateCommand::class,
        PluginDeactivateCommand::class
    ];

    /**
     * Get list command active
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }
}
