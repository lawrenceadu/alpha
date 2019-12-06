<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', '');
set('path', '{{application}}');

// Project repository
set('repository', '');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false); 

// Shared files/dirs between deploys 
set('shared_files', [
    'error_log',
    'app/config/config.ini'
]);
set('shared_dirs', [

]);

// Writable dirs by web server 
set('writable_dirs', []);

set('default_stage', 'production');
// set('keep_releases', 5);

// Hosts
host('{{}}')
    ->port()
    ->set('deploy_path', '{{path}}')
    ->user('user')  
    ->set('branch', 'master')
    ->stage('production')
    ->identityFile('');
    
task('vendor', function(){
    run('cd {{release_path}} && {{bin/composer}} {{composer_options}}');
});

task('upload', function(){
    upload(".env.prod", "{{release_path}}/.env");
});

task('migrate', function(){
    run('{{release_path}}');
    run('php alpha db:migrate');
    // can run a rollback and seed in this task   
});

// Tasks
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'upload',
    'vendor',
    'migrate',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
