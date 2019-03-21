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
        Scripts\InstallCommand::class,
        Scripts\DumpAutoload::class,
        Scripts\MakeRepositoryCommand::class,
        Scripts\MakeBindContentRepository::class,
        Scripts\MigrateSystemCommand::class,
        Scripts\PublishConfig::class,
        Scripts\PublishData::class,
        Scripts\BuildPermissions::class,
        Scripts\RebuildPermissionsCommand::class,
        Scripts\PluginCreateCommand::class,
        Scripts\PluginActivateCommand::class,
        Scripts\PluginDeactivateCommand::class,
        Scripts\PluginRemoveCommand::class,
        Scripts\CreateUserCommand::class
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
