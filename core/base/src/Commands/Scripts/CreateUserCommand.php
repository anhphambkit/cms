<?php

namespace Core\Base\Commands\Scripts;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Core\User\Repositories\Interfaces\UserInterface;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate user';

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
        $this->info('Creating a Super User...');
        $user                = app(UserInterface::class)->getModel();
        $user->first_name    = $this->ask('Enter your first name');
        $user->last_name     = $this->ask('Enter your last name');
        $user->username      = $this->ask('Enter your username');
        $user->email         = $this->ask('Enter your email address');
        $user->super_user    = 1;
        $user->manage_supers = 1;
        $user->password      = bcrypt($this->secret('Enter a password'));
        $user->profile_image = config('base-user.acl.avatar.default');

        try {
            app(UserInterface::class)->createOrUpdate($user);
            if (acl_activate_user($user)) {
                $this->info('Super user is created.');
            }
        } catch (Exception $e) {
            $this->error('User could not be created.');
            $this->error($e->getMessage());
        }

        $this->line('------------------');
    }
}