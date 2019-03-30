<?php 
namespace Core\User\Services\Excute;
use Core\Master\Services\CoreServiceAbstract;
use Core\User\Services\Interfaces\RoleServiceInterface;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\FeatureRepositories;
use Core\User\Repositories\Interfaces\PermissionRepositories;

class RoleServiceExcute extends CoreServiceAbstract implements RoleServiceInterface
{	
	/**
	 * @var RoleInterface
	 */
	protected $roleInterface;

	/**
	 * @var FeatureRepositories
	 */
	protected $featureInterface;

	/**
	 * @var PermissionRepositories
	 */
	protected $permissionInterface;

	function __construct(RoleInterface $roleInterface, FeatureRepositories $featureInterface, PermissionRepositories $permissionInterface)
	{
		$this->roleInterface       = $roleInterface;
		$this->featureInterface    = $featureInterface;
		$this->permissionInterface = $permissionInterface;
	}

	/**
     * @param $parentId
     * @param $allFlags
     * @param $availableFeatures
     * @return mixed
     * @author TrinhLe
     */
    private function getChildren($parentId, $allFlags, $availableFeatures)
    {
        $newFlagArray = [];
        foreach ($allFlags as $flagDetails) {
            if ($flagDetails->parent_flag == $parentId) {
                if ($flagDetails->is_feature && in_array($flagDetails->id, $availableFeatures)) {
                    $newFlagArray[] = $flagDetails->id;
                } elseif ($flagDetails->is_feature == 0) {
                    $newFlagArray[] = $flagDetails->id;
                }
            }
        }
        return $newFlagArray;
    }

	/**
	 * Get flags
	 * @param array $array 
	 * @author TrinhLe
	 * @return mixed
	 */
	public function getFlagsPermission():array
	{
		$usableFlags = $this->permissionInterface->getVisiblePermissions(['id', 'flag', 'name', 'parent_flag', 'is_feature']);

        $availableFeatures = $this->featureInterface->pluck('feature_id');

        $flags = [];

        foreach ($usableFlags as $usableFlag) {
            if ($usableFlag->is_feature && in_array($usableFlag->id, $availableFeatures)) {
                $flags[$usableFlag->id] = $usableFlag;
            } elseif ($usableFlag->is_feature == 0) {
                $flags[$usableFlag->id] = $usableFlag;
            }
        }

        $sortedFlag = $flags;
        sort($sortedFlag);
        $children[0] = $this->getChildren(0, $sortedFlag, $availableFeatures);

        foreach ($flags as $flagDetails) {
            $childrenReturned = $this->getChildren($flagDetails->id, $flags, $availableFeatures);
            if (count($childrenReturned) > 0) {
                if ($flagDetails->is_feature && in_array($flagDetails->id, $availableFeatures)) {
                    $children[$flagDetails->id] = $childrenReturned;
                } elseif ($flagDetails->is_feature == 0) {
                    $children[$flagDetails->id] = $childrenReturned;
                }
            }
        }

        return [$flags, $children];
	}
}