<?php

namespace Plugins\Product\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Models\ProductGallery;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;
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
     * @var ManufacturerRepositories
     */
    protected $manufacturerRepositories;

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
     * @var ProductSpaceRepositories
     */
    protected $productSpaceRepositories;

    /**
     * @var CustomAttributesRepositories
     */
    protected $customAttributesRepositories;

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @param ManufacturerRepositories $manufacturerRepositories
     * @param ProductColorRepositories $productColorRepositories
     * @param BusinessTypeRepositories $businessTypeRepositories
     * @param ProductCollectionRepositories $productCollectionRepositories
     * @param ProductMaterialRepositories $productMaterialRepositories
     * @param ProductSpaceRepositories $productSpaceRepositories
     * @param CustomAttributesRepositories $customAttributesRepositories
     */
    public function __construct(ProductRepositories $productRepository, ProductCategoryRepositories $productCategoryRepositories,
                                ManufacturerRepositories $manufacturerRepositories, ProductColorRepositories $productColorRepositories,
                                BusinessTypeRepositories $businessTypeRepositories, ProductCollectionRepositories $productCollectionRepositories,
                                ProductMaterialRepositories $productMaterialRepositories, ProductSpaceRepositories $productSpaceRepositories,
                                CustomAttributesRepositories $customAttributesRepositories)
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepositories = $productCategoryRepositories;
        $this->manufacturerRepositories = $manufacturerRepositories;
        $this->productColorRepositories = $productColorRepositories;
        $this->businessTypeRepositories = $businessTypeRepositories;
        $this->productCollectionRepositories = $productCollectionRepositories;
        $this->productMaterialRepositories = $productMaterialRepositories;
        $this->productSpaceRepositories = $productSpaceRepositories;
        $this->customAttributesRepositories = $customAttributesRepositories;
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
        return $dataTable->render('plugins-product::product.index');
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $categories = $this->productCategoryRepositories->pluck('name', 'id');

        $manufacturer = $this->manufacturerRepositories->pluck('name', 'id');

        $colors = $this->productColorRepositories->pluck('name', 'id');

        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');

        $collections = $this->productCollectionRepositories->pluck('name', 'id');

        $materials = $this->productMaterialRepositories->pluck('name', 'id');

        $spaces = $this->productSpaceRepositories->select(['id', 'name as text', 'image_feature'])->get();

        $productAttributes = $this->customAttributesRepositories->allBy([
           [ 'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT) ]
        ], [], [ 'id', 'name as text', 'slug' ]);

        page_title()->setTitle(trans('plugins-product::product.create'));

        $this->addDetailAssets();

        return view('plugins-product::product.create', compact('categories', 'manufacturer', 'colors', 'businessTypes', 'collections', 'materials', 'spaces', 'productAttributes'));
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
        $data['is_best_seller'] = $request->input('is_best_seller', false);
        $data['available_3d'] = $request->input('available_3d', false);
        $data['has_assembly'] = $request->input('has_assembly', false);
        $data['is_outdoor'] = $request->input('is_outdoor', false);
        $data['sku'] = "{$data['manufacturer_id']}{$data['sku']}";
        $data['image_gallery'] = $request->input('image_gallery', "[]");
        $data['category_id'] = $request->input('category_id', []);
        $data['business_type_id'] = $request->input('business_type_id', []);
        $data['collection_id'] = $request->input('collection_id', []);
        $data['color_id'] = $request->input('color_id', []);
        $data['material_id'] = $request->input('material_id', []);
        $data['created_by'] = Auth::id();

        $productMaster = DB::transaction(function () use ($data) {
            // Variant Products:
            $variantProducts = (!empty($data['variant_products']) ? $data['variant_products'] : []);
            $data['type_product'] = !empty($variantProduct) ? ProductReferenceConfig::PRODUCT_TYPE_VARIANT : ProductReferenceConfig::PRODUCT_TYPE_SIMPLE;

            $productMaster = $this->createSingleProduct($data);
            
            foreach ($variantProducts as $variantProduct) {
                // Prepare data variant:
                $variantProduct['parent_product_id'] = $productMaster->id;
                $variantProduct['slug'] = str_slug($variantProduct['name']);
                $variantProduct['sku'] = "{$data['manufacturer_id']}{$variantProduct['sku']}";
                $variantProduct['status'] = $data['status'];
                $variantProduct['category_id'] = $data['category_id'];
                $variantProduct['manufacturer_id'] = $data['manufacturer_id'];
                $variantProduct['is_best_seller'] = $data['is_best_seller'];
                $variantProduct['available_3d'] = $data['available_3d'];
                $variantProduct['has_assembly'] = $data['has_assembly'];
                $variantProduct['is_outdoor'] = $data['is_outdoor'];
                $variantProduct['image_gallery'] = !empty($variantProduct['image_gallery']) ? $variantProduct['image_gallery'] : [];
                $variantProduct['category_id'] = $data['category_id'];
                $variantProduct['business_type_id'] = $data['business_type_id'];
                $variantProduct['collection_id'] = $data['collection_id'];
                $variantProduct['color_id'] = $data['color_id'];
                $variantProduct['material_id'] = $data['material_id'];
                $variantProduct['type_product'] = ProductReferenceConfig::PRODUCT_TYPE_CHILD_VARIANT;
                $variantProduct['created_by'] = Auth::id();

                foreach ($data as $key => $dataAttribute) {
                    $variantProduct[$key] = !empty($variantProduct["is_same_{$key}"]) ? $dataAttribute : (!empty($variantProduct[$key]) ? $variantProduct[$key] : null);
                }

                $this->createSingleProduct($variantProduct);
            }
            $productMaster->save();
            return $productMaster;
        }, 3);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $productMaster);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.edit', $productMaster->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function createSingleProduct($data) {
        $product = $this->productRepository->createOrUpdate($data);

        $galleries = json_decode($data['image_gallery']);

        if (!empty($galleries)) {
            foreach ($galleries as $gallery) {
                $product->galleries()->create([
                    'media' => $gallery,
//                    'description' => $gallery->description,
                ]);
            }
        }

        if (!empty($data['category_id']))
            $product->productCategories()->attach($data['category_id']);

        if (!empty($data['business_type_id']))
            $product->productBusinessTypes()->attach($data['business_type_id']);

        if (!empty($data['collection_id']))
            $product->productCollections()->attach($data['collection_id']);

        if (!empty($data['color_id']))
            $product->productColors()->attach($data['color_id']);

        if (!empty($data['material_id']))
            $product->productMaterials()->attach($data['material_id']);

        // Business space product
        $productSpaces = (!empty($data['space_business']) ? $data['space_business'] : []);
        $product->productBusinessSpaces()->createMany($productSpaces);

        $productAllSpaces = (!empty($data['all_space']) ? $data['all_space'] : []);
        
        foreach ($productAllSpaces as $productAllSpace) {
            $product->productBusinessSpaces()->create([
                'business_type_id' => 0,
                'space_id' => $productAllSpace['space_id'],
                'apply_all' => true
            ]);
        }

        // Attribute value product
        $productCustomAttributes = (!empty($data['product_attribute']) ? $data['product_attribute'] : []);
        foreach ($productCustomAttributes as $productCustomAttribute) {
            $valueAttributes = (!empty($productCustomAttribute['value_attributes']) ? $productCustomAttribute['value_attributes'] : []);
            foreach ($valueAttributes as $valueAttribute) {
                $product->productAttributeValues()->create([
                    'attribute_id' => $productCustomAttribute['attribute_id'],
                    'attribute_value_id' => $valueAttribute,
                ]);
            }
        }

        $productCustomAttributes = (!empty($data['combination']) ? $data['combination'] : []);
        foreach ($productCustomAttributes as $productCustomAttribute) {
            $product->productAttributeValues()->create([
                'attribute_id' => $productCustomAttribute['attribute_id'],
                'attribute_value_id' => $productCustomAttribute['value_id'],
            ]);
        }

        $product->sku .= $product->id;

        $product->save();

        return $product;
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
        $categories = $this->productCategoryRepositories->pluck('name', 'id');

        $manufacturer = $this->manufacturerRepositories->pluck('name', 'id');

        $colors = $this->productColorRepositories->pluck('name', 'id');

        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');

        $collections = $this->productCollectionRepositories->pluck('name', 'id');

        $materials = $this->productMaterialRepositories->pluck('name', 'id');

        $spaces = $this->productSpaceRepositories->select(['id', 'name as text', 'image_feature'])->get();

        $productAttributes = $this->customAttributesRepositories->allBy([
            [ 'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT) ]
        ], [], [ 'id', 'name as text', 'slug' ]);

        $product = $this->productRepository->findById($id);

        $selectedProductCategories = [];
        if ($product->productCategories != null) {
            $selectedProductCategories = $product->productCategories->pluck('id')->all();
        }

        $selectedProductBusinessTypes = [];
        if ($product->productBusinessTypes != null) {
            $selectedProductBusinessTypes = $product->productBusinessTypes->pluck('id')->all();
        }

        $selectedProductCollections = [];
        if ($product->productCollections != null) {
            $selectedProductCollections = $product->productCollections->pluck('id')->all();
        }

        $selectedProductColors = [];
        if ($product->productColors != null) {
            $selectedProductColors = $product->productColors->pluck('id')->all();
        }

        $selectedProductMaterials = [];
        if ($product->productMaterials != null) {
            $selectedProductMaterials = $product->productMaterials->pluck('id')->all();
        }

        $galleries = [];
        if ($product->galleries != null) {
            $galleries = $product->galleries->pluck('media')->all();
        }

        $businessSpaces = [];
        $allSpaces = [];
        if ($product->productBusinessSpaces() != null) {
            $businessSpaces = $product->productBusinessSpaces()->where('product_business_type_space_relation.apply_all', false)->select('*')->get()->toArray();
            $allSpaces = $product->productBusinessSpaces()->where('product_business_type_space_relation.apply_all', true)->select('*')->get()->toArray();
        }

        if (empty($product)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::product.edit') . ' #' . $id);

        $this->addDetailAssets();

        return view('plugins-product::product.edit', compact('product', 'categories', 'manufacturer', 'colors',
                    'businessTypes', 'collections', 'materials', 'spaces', 'productAttributes',
                    'selectedProductCategories', 'selectedProductBusinessTypes', 'businessSpaces', 'allSpaces',
                    'selectedProductCollections', 'selectedProductColors', 'selectedProductMaterials', 'galleries'));
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


        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['is_best_seller'] = $request->input('is_best_seller', false);
        $data['available_3d'] = $request->input('available_3d', false);
        $data['has_assembly'] = $request->input('has_assembly', false);
        $data['is_outdoor'] = $request->input('is_outdoor', false);
        $data['sku'] = "{$data['manufacturer_id']}{$data['sku']}{$id}";
        $data['updated_by'] = Auth::id();

        $product = DB::transaction(function () use ($data, $product, $request) {
            $product->fill($data);

            $this->productRepository->createOrUpdate($product);

            $galleries = json_decode($request->input('image_gallery', "[]"));

            ProductGallery::with('product')->where('product_id', $product->id)->delete();

            foreach ($galleries as $gallery) {
                $product->galleries()->create([
                    'media' => $gallery,
//                    'description' => $gallery->description,
                ]);
            }

            $categoryIds = $request->input('category_id', []);
            $product->productCategories()->detach();
            $product->productCategories()->attach($categoryIds);

            $businessTypeIds = $request->input('business_type_id', []);
            $product->productBusinessTypes()->detach();
            $product->productBusinessTypes()->attach($businessTypeIds);

            $collectionIds = $request->input('collection_id', []);
            $product->productCollections()->detach();
            $product->productCollections()->attach($collectionIds);

            $colorIds = $request->input('color_id', []);
            $product->productColors()->detach();
            $product->productColors()->attach($colorIds);

            $materialIds = $request->input('material_id', []);
            $product->productMaterials()->detach();
            $product->productMaterials()->attach($materialIds);

            return $product;
        }, 3);


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
        AssetManager::addAsset('bootstrap-switch-css', 'libs/plugins/product/css/toggle/bootstrap-switch.min.css');
        AssetManager::addAsset('switchery-css', 'libs/plugins/product/css/toggle/switchery.min.css');
        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetManager::addAsset('admin-gallery-css', 'libs/core/base/css/gallery/admin-gallery.css');
        AssetManager::addAsset('custom-partials-css', 'backend/plugins/product/assets/css/custom-partials.css');
        AssetManager::addAsset('product-css', 'backend/plugins/product/assets/css/product.css');

        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('bootstrap-switch-js', 'libs/plugins/product/js/toggle/bootstrap-switch.min.js');
        AssetManager::addAsset('bootstrap-checkbox-js', 'libs/plugins/product/js/toggle/bootstrap-checkbox.min.js');
        AssetManager::addAsset('switchery-js', 'libs/plugins/product/js/toggle/switchery.min.js');
        AssetManager::addAsset('form-select2-js', 'backend/plugins/product/assets/scripts/form-select2.min.js');
        AssetManager::addAsset('switch-js', 'backend/plugins/product/assets/scripts/switch.min.js');
        AssetManager::addAsset('core-helper-js', 'backend/core/base/assets/js/helper.js');
        AssetManager::addAsset('select2-helper-js', 'backend/plugins/product/assets/js/select2-helper.js');
        AssetManager::addAsset('variants-js', 'backend/plugins/product/assets/js/variants.js');
        AssetManager::addAsset('business-spaces-js', 'backend/plugins/product/assets/js/business-spaces.js');
        AssetManager::addAsset('product-js', 'backend/plugins/product/assets/js/product.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('bootstrap-switch-css');
        AssetPipeline::requireCss('switchery-css');
        AssetPipeline::requireCss('pretty-checkbox');
        AssetPipeline::requireCss('admin-gallery-css');
        AssetPipeline::requireCss('custom-partials-css');
        AssetPipeline::requireCss('product-css');

        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('bootstrap-switch-js');
        AssetPipeline::requireJs('bootstrap-checkbox-js');
        AssetPipeline::requireJs('switchery-js');
        AssetPipeline::requireJs('form-select2-js');
        AssetPipeline::requireJs('switch-js');
        AssetPipeline::requireJs('core-helper-js');
        AssetPipeline::requireJs('select2-helper-js');
        AssetPipeline::requireJs('variants-js');
        AssetPipeline::requireJs('business-spaces-js');
        AssetPipeline::requireJs('product-js');
    }
}
