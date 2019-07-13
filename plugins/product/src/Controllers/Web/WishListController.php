<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-13
 * Time: 20:43
 */

namespace Plugins\Product\Controllers\Web;

use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use AssetManager;
use AssetPipeline;
use Plugins\Product\Services\LookBookServices;

class WishListController extends BasePublicController
{
    /**
     * @var WishListRepositories
     */
    protected $wishListRepositories;

    /**
     * @var LookBookServices
     */
    protected $lookBookServices;

    /**
     * WishListController constructor.
     * @param WishListRepositories $wishListRepositories
     * @param LookBookServices $lookBookServices
     */
    public function __construct(WishListRepositories $wishListRepositories, LookBookServices $lookBookServices)
    {
        $this->wishListRepositories = $wishListRepositories;
        $this->lookBookServices = $lookBookServices;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProductWishList() {
        $customerId = (int)Auth::guard('customer')->id();
        $wishListProducts = $this->wishListRepositories->allBy([
            [
                'customer_id', '=', $customerId,
            ],
            [
                'entity_type', '=', ProductReferenceConfig::ENTITY_TYPE_PRODUCT,
            ]
        ], ['entity'], ['*'])
        ->mapToGroups(function ($item, $key) {
            if ($item->entity)
                return [$item['entity_type'] => $item->entity];
            return [ 'fails' => null ];
        });

        $wishListLookBooks = $this->wishListRepositories->allBy([
            [
                'customer_id', '=', $customerId,
            ],
            [
                'entity_type', '=', ProductReferenceConfig::ENTITY_TYPE_LOOK_BOOK,
            ]
        ], ['entity', 'entity.lookBookTags', 'entity.lookBookSpacesBelong', 'entity.lookBookBusiness', 'entity.lookBookProducts', 'entity.wishListLookBooks'], ['*'])
        ->mapToGroups(function ($item, $key) {
            if ($item->entity)
                return [$item['entity_type'] => $item->entity];
            return [ 'fails' => null ];
        });

        $wishListRenderLookBooks = $this->lookBookServices->renderListBlockLookBookFromCollectionLookBook($wishListLookBooks[ProductReferenceConfig::ENTITY_TYPE_LOOK_BOOK]);

        $wishListEntities = [
            ProductReferenceConfig::ENTITY_TYPE_PRODUCT => $wishListProducts[ProductReferenceConfig::ENTITY_TYPE_PRODUCT],
            ProductReferenceConfig::ENTITY_TYPE_LOOK_BOOK => $wishListRenderLookBooks,
        ];

        $this->getAssetProductDetail();
        $this->getAssetDesignIdea();

        return view('pages.wish-list.wish-list', compact('wishListEntities'));
    }

    protected function getAssetDesignIdea() {
        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');
    }

    protected function getAssetProductDetail() {
        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');
    }
}