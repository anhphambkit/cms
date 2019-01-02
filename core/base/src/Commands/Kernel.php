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
        DumpAutoload::class,
        PublishConfig::class,
        PluginCreateCommand::class
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
