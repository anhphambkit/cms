<?php
namespace Deployer;

require 'recipe/symfony.php';

require_once(__DIR__ .'/readEnv.php');
$env = new \readEnv();
$env->convertEnv();

// Project name
set('application', 'CMS');
set('default_timeout', 2000);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

# Config deploy
# DEPLOY_ENV=local
# DEPLOY_HOST=167.99.65.20
# DEPLOY_PORT=70
# DEPLOY_USER=root
# DEPLOY_PATH=/var/www/html
# DEPLOY_PERMISSION=www-data:www-data
# DEPLOY_CERTIFICATE=/root/.ssh/ssh_bigin_top

if($env->getEnv('DEPLOY_ENV') === 'production')
{
    # setup deploy host in here
    host($env->getEnv('DEPLOY_HOST'))
    ->user($env->getEnv('DEPLOY_USER'))
    ->port($env->getEnv('DEPLOY_PORT')) //68 : qa - 70 : dev
    ->identityFile($env->getEnv('DEPLOY_CERTIFICATE'))
    ->set('deploy_path', $env->getEnv('DEPLOY_PATH'))
    ->set('permission', $env->getEnv('DEPLOY_PERMISSION'))
    ->multiplexing(true);
}
else
{
    set('deploy_path', '/var/www/html');
}

# deploy build maintenance
task('deploy:dev', [
  
]);

after('deploy:failed', 'deploy:restore');
