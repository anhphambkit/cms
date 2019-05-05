<?php

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductCouponDataTable;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;
use Plugins\Product\Requests\ProductCouponRequest;
use Core\Base\Responses\BaseHttpResponse;
use AssetManager;
use AssetPipeline;

class ProductCouponController extends BaseAdminController
{
    /**
     * @var ProductCouponRepositories
     */
    protected $productCouponRepository;

    /**
     * ProductController constructor.
     * @param ProductCouponRepositories $productCouponRepository
     * @author TrinhLe
     */
    public function __construct(ProductCouponRepositories $productCouponRepository)
    {
        $this->productCouponRepository = $productCouponRepository;
    }

    /**
     * [addAssets description]
     */
    protected function addAssets(){
        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');
    }

    /**
     * Display all material
     * @param ProductCouponDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(ProductCouponDataTable $dataTable)
    {
        
        page_title()->setTitle(trans('plugins-product::coupon.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::coupon.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        $this->addAssets();
        page_title()->setTitle(trans('plugins-product::coupon.create'));

        $categories = [0 => trans('plugins-blog::categories.none')];

        return view('plugins-product::coupon.create', compact('categories'));
    }

    /**
     * @param ProductCouponRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductCouponRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $material = $this->productCouponRepository->createOrUpdate($data);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.material.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.material.edit', $material->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getEdit($id)
    {
        $material = $this->productCouponRepository->findById($id);
        if (empty($material)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::coupon.edit') . ' #' . $id);

        return view('plugins-product::coupon.edit', compact('material'));
    }

    /**
     * @param $id
     * @param ProductCouponRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductCouponRequest $request, BaseHttpResponse $response)
    {
        $material = $this->productCouponRepository->findById($id);
        if (empty($material)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $material->fill($data);

        $this->productCouponRepository->createOrUpdate($material);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.material.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.material.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $material = $this->productCouponRepository->findById($id);
            if (empty($material)) {
                abort(404);
            }
            $this->productCouponRepository->delete($material);

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
}