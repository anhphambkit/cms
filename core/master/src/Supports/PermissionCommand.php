<?php

namespace Core\Master\Supports;

use Core\User\Models\Feature;
use Core\User\Models\PermissionFlag;
use Core\Base\Commands\RebuildPermissionsCommand;

class PermissionCommand
{
    /**
     * @param $permissions
     * @author Sang Nguyen
     */
    public static function registerPermission($permissions)
    {
        foreach ($permissions as $permission) {
            $permission = PermissionFlag::createNewPermissionFlag($permission);
            if (!empty($permission)) {
                if ($permission->is_feature) {
                    $feature = new Feature();
                    $feature->firstOrCreate(['feature_id' => $permission->id]);
                }
            }
        }
        $permissionRebuild = new RebuildPermissionsCommand();
        $permissionRebuild->handle(true);
    }

    /**
     * @param $permissions
     * @author Sang Nguyen
     */
    public static function removePermission($permissions)
    {
        foreach ($permissions as $permission) {
            $permission = PermissionFlag::where('flag', '=', $permission['flag'])->first();
            if ($permission) {
                if ($permission->is_feature) {
                    Feature::where('feature_id', '=', $permission->id)->forceDelete();
                }
                $permission->forceDelete();
            }
        }
        $permissionRebuild = new RebuildPermissionsCommand();
        $permissionRebuild->handle(true);
    }
}