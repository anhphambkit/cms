<?php

namespace Plugins\Product\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Product\Repositories\Interfaces\BrandRepositories;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
use Plugins\Product\Requests\ProductRequest;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\DataTables\ProductDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;

class ProductController extends BaseAdminController
{
    /**
     * @var ProductRepositories
     */
    protected $productRepository;

    /**
     * @var ProductCategoryRepositories
     */
    protected $productCategoryRepositories;

    /**
     * @var BrandRepositories
     */
    protected $brandRepositories;

    /**
     * @var ProductColorRepositories
     */
    protected $productColorRepositories;

    /**
     * @var BusinessTypeRepositories
     */
    protected $businessTypeRepositories;

    /**
     * @var ProductCollectionRepositories
     */
    protected $productCollectionRepositories;

    /**
     * @var ProductMaterialRepositories
     */
    protected $productMaterialRepositories;

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @param BrandRepositories $brandRepositories
     * @param ProductColorRepositories $productColorRepositories
     * @param BusinessTypeRepositories $businessTypeRepositories
     * @param ProductCollectionRepositories $productCollectionRepositories
     * @param ProductMaterialRepositories $productMaterialRepositories
     */
    public function __construct(ProductRepositories $productRepository, ProductCategoryRepositories $productCategoryRepositories,
                                BrandRepositories $brandRepositories, ProductColorRepositories $productColorRepositories,
                                BusinessTypeRepositories $businessTypeRepositories, ProductCollectionRepositories $productCollectionRepositories,
                                ProductMaterialRepositories $productMaterialRepositories)
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepositories = $productCategoryRepositories;
        $this->brandRepositories = $brandRepositories;
        $this->productColorRepositories = $productColorRepositories;
        $this->businessTypeRepositories = $businessTypeRepositories;
        $this->productCollectionRepositories = $productCollectionRepositories;
        $this->productMaterialRepositories = $productMaterialRepositories;
    }

    /**
     * Display all product
     * @param ProductDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::product.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::product.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $categories = $this->productCategoryRepositories->pluck('name', 'id');

//        $categories = array_merge([ 0 => "Please select parent product category" ], $categories);

        $brand = $this->brandRepositories->pluck('name', 'id');

//        $brand = array_merge([ 0 => "Please select a brand" ], $brand);

        $colors = $this->productColorRepositories->pluck('name', 'id');

//        $colors = array_merge([ 0 => "Please select a color" ], $colors);

        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');

//        $businessTypes = array_merge([ 0 => "Please select a business type" ], $businessTypes);

        $collections = $this->productCollectionRepositories->pluck('name', 'id');

//        $collections = array_merge([ 0 => "Please select a collection" ], $collections);

        $materials = $this->productMaterialRepositories->pluck('name', 'id');

//        $materials = array_merge([ 0 => "Please select a material" ], $materials);

        page_title()->setTitle(trans('plugins-product::product.create'));

        $this->addDetailAssets();

        return view('plugins-product::product.create', compact('categories', 'brand', 'colors', 'businessTypes', 'collections', 'materials'));
    }

    /**
     * Insert new Product into database
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postCreate(ProductRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);

        $data['sku'] = "{$data['brand_id']}{$data['sku']}{$data['brand_id']}";

        $product = $this->productRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $product);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.edit', $product->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getEdit($id)
    {
        $product = $this->productRepository->findById($id);
        if (empty($product)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::product.edit') . ' #' . $id);

        return view('plugins-product::edit', compact('product'));
    }

    /**
     * @param $id
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postEdit($id, ProductRequest $request)
    {
        $product = $this->productRepository->findById($id);
        if (empty($product)) {
            abort(404);
        }
        $product->fill($request->input());

        $this->productRepository->createOrUpdate($product);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $product);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author AnhPham
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $product = $this->productRepository->findById($id);
            if (empty($product)) {
                abort(404);
            }
            $this->productRepository->delete($product);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $product);

            return [
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ];
        }
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/plugins/product/css/select2/select2.min.css');
        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('bootstrap-switch-css', 'libs/plugins/product/css/toggle/bootstrap-switch.min.css');
        AssetManager::addAsset('bootstrap-switch-js', 'libs/plugins/product/js/toggle/bootstrap-switch.min.js');
        AssetManager::addAsset('bootstrap-checkbox-js', 'libs/plugins/product/js/toggle/bootstrap-checkbox.min.js');
        AssetManager::addAsset('switchery-css', 'libs/plugins/product/css/toggle/switchery.min.css');
        AssetManager::addAsset('switchery-js', 'libs/plugins/product/js/toggle/switchery.min.js');
        AssetManager::addAsset('form-select2-js', 'backend/plugins/product/assets/scripts/form-select2.min.js');
        AssetManager::addAsset('switch-js', 'backend/plugins/product/assets/scripts/switch.min.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('bootstrap-switch-css');
        AssetPipeline::requireCss('switchery-css');
        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('bootstrap-switch-js');
        AssetPipeline::requireJs('bootstrap-checkbox-js');
        AssetPipeline::requireJs('switchery-js');
        AssetPipeline::requireJs('form-select2-js');
        AssetPipeline::requireJs('switch-js');
    }
}
