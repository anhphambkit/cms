<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-24
 * Time: 22:40
 */

namespace Plugins\CustomAttributes\Controllers\Ajax\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class CustomAttributesController extends BaseAdminController
{
    /**
     * @var CustomAttributeServices
     */
    protected $customAttributeServices;

    /**
     * @var CustomAttributesRepositories
     */
    protected $customAttributesRepositories;

    /**
     * CustomAttributesController constructor.
     * @param CustomAttributeServices $customAttributeServices
     * @param CustomAttributesRepositories $customAttributesRepositories
     */
    public function __construct(CustomAttributeServices $customAttributeServices, CustomAttributesRepositories $customAttributesRepositories)
    {
        $this->customAttributeServices = $customAttributeServices;
        $this->customAttributesRepositories = $customAttributesRepositories;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListValueCustomAttributes(Request $request)
    {
        $attributeId = (int)$request->get('attribute_id');
        $attributes = $this->customAttributeServices->getAttributesValueByAttributeId($attributeId);
        return response()->json($attributes);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomAttributes(Request $request) {
        $productAttributes = $this->customAttributesRepositories->allBy([
            [ 'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT) ]
        ], [], [ 'id', 'name as text', 'slug' ]);

        return response()->json($productAttributes);
    }
}