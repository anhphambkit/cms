<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\RoleDataTable;
use AssetManager;
use AssetPipeline;
use Core\User\Services\Interfaces\RoleServiceInterface;

class RoleController extends BaseAdminController
{
    
    /**
     * @var RoleServiceInterface
     */
    protected $roleService;

    function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Show page dashboard role
     * @author TrinhLe
     * @return View
     */
    public function index(RoleDataTable $dataTable)
    {
        $roles = [];
        return $dataTable->render('core-user::admin.role.index', compact('roles'));
    }

    /**
     * Show page dashboard role
     * @author TrinhLe
     * @return View
     */
    public function getCreate()
    {
        AssetPipeline::requireCss('jquery-tree-css');
        AssetPipeline::requireJs('jquery-tree-js');

        // $usableFlags = $this->roleService->getFlagsPermission(['id', 'name', 'parent_flag', 'is_feature']);

        // $availableFeatures = $this->roleService->featurePluck('feature_id');

        // $flags = [];

        // if ($usableFlags) {
        //     foreach ($usableFlags as $usableFlag) {
        //         if ($usableFlag->is_feature && in_array($usableFlag->id, $availableFeatures)) {
        //             $flags[$usableFlag->id] = $usableFlag;
        //         } elseif ($usableFlag->is_feature == 0) {
        //             $flags[$usableFlag->id] = $usableFlag;
        //         }

        //     }
        // }

        // $sortedFlag = $flags;
        // sort($sortedFlag);
        // $children[0] = $this->getChildren(0, $sortedFlag, $availableFeatures);

        // foreach ($flags as $flagDetails) {
        //     $childrenReturned = $this->getChildren($flagDetails->id, $flags, $availableFeatures);
        //     if (count($childrenReturned) > 0) {
        //         if ($flagDetails->is_feature && in_array($flagDetails->id, $availableFeatures)) {
        //             $children[$flagDetails->id] = $childrenReturned;
        //         } elseif ($flagDetails->is_feature == 0) {
        //             $children[$flagDetails->id] = $childrenReturned;
        //         }
        //     }
        // }

        return view('core-user::admin.role.create',compact(''));
    }

    /**
     * Show page dashboard role
     * @author TrinhLe
     * @return View
     */
    public function postCreate(RoleDataTable $dataTable)
    {
        $roles = [];
        return $dataTable->render('core-user::admin.role.index', compact('roles'));
    }
}