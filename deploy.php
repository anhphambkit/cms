<?php
namespace Deployer;

require 'recipe/symfony.php';

require_once(__DIR__ .'/readEnv.php');
$env = new \readEnv();
$env->convertEnv('.env_deploy');

// Project name
set('application', $env->getEnv('DEPLOY_APPLICATION'));
set('default_timeout', $env->getEnv('DEPLOY_TIMEOUT') ?? 2000);
set('git_tty', true);
add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);
set('deploy_path', $env->getEnv('DEPLOY_PATH_LOCAL'));

task('deploy:dev', [
    'deploy:start',
    'deploy:source-lib',
    'deploy:build',
]);

task('deploy:start', function(){ // 
    writeln('Start deployer');
});

task('deploy:source-lib', function(){ // 
    writeln('Install vendors by composer');
    try {
        $path = get('deploy_path');
        run("cd {$path}/Upload && COMPOSER_PROCESS_TIMEOUT=2000 composer install");
        run("cd {$path}/Upload && npm install");
        run("cd {$path}/Upload && npm uninstall b-components");
        run("cd {$path}/Upload && npm install --save-dev biginvn/b-components");
        run("cd {$path}/SmartTask && COMPOSER_PROCESS_TIMEOUT=2000 composer install");
        run("cd {$path}/NodeNotification && npm install");
    } catch (\Symfony\Component\Process\Exception\ProcessFailedException $e) {
        writeln($e->getMessage());
    }
});

task('deploy:build', function(){
    $path = get('deploy_path');
    $modules = [
        'webpack/module-reset.config.js',
        'webpack/module-login.config.js',
        'webpack/module-user.config.js',
        'webpack/module-user-profile.config.js',
        'webpack/module-role.config.js',
        'webpack/module-task.config.js',
        'webpack/module-template.config.js',
        'webpack/module-customization.config.js',
        'webpack/module-smart-task.config.js',
        'webpack/module-dashboard.config.js',
        'webpack/module-file-summary-report.config.js',
        'webpack/module-coordinator-summary.config.js',
        'webpack/module-relocation-client-report.config.js',
        'webpack/module-home-sale-report.config.js',
        'webpack/module-home-purchases-report.config.js',
        'webpack/module-service-vendor-report.config.js',
        'webpack/module-user-activity-report.config.js',
        'webpack/module-ad-hoc-report.config.js',
        'webpack/module-notification.config.js',
        'webpack/module-client-refactor.config.js',
        'webpack/module-vendor-refactor.config.js',
        'webpack/module-transferee-refactor.config.js',
        'webpack/module-mini-dashboard-refactor.config.js',
        'webpack/pusher.config.js',
    ];

    foreach ($modules as $key => $module) {
        # code...
        run("cd {$path}/Upload && NODE_ENV=production ./node_modules/.bin/webpack --config {$module}");
    }
});

after('deploy:failed', 'deploy:restore');