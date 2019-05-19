<?php

namespace Core\Base\Commands\Scripts;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Core\Media\Models\MediaFile;
use Core\Media\Models\MediaFolder;
use Illuminate\Contracts\Filesystem\Factory;
use Core\User\Models\User;
use Illuminate\Support\Facades\Hash;

use Plugins\Customer\Notifications\ConfirmEmail;
use Plugins\Customer\Models\Customer;

class CommandTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate command';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @param Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $customer = Customer::find(5);
        $customer->notify(new ConfirmEmail());
    }
}