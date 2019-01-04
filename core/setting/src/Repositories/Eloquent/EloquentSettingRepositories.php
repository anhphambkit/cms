<?php
/**
 * Setting repository implemented
 */
namespace Core\Setting\Repositories\Eloquent;
use Core\Setting\Repositories\{c repo}Repositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentSettingRepositories implements SettingRepositories {
    use RepositoriesAbstract;
}