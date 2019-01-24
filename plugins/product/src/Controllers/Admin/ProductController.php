<?php

namespace Plugins\Product\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Product\Requests\ProductRequest;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Http\DataTables\ProductDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class ProductController extends BaseAdminController
{
    /**
     * @var ProductRepositories
     */
    protected $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     * @author TrinhLe
     */
    public function __construct(ProductRepositories $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display all product
     * @param ProductDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(ProductDataTable $dataTable)
    {

        page_title()->setTitle(trans('product::product.list'));

        return $dataTable->renderTable(['title' => trans('product::product.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('product::product.create'));

        return view('product::create');
    }

    /**
     * Insert new Product into database
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(ProductRequest $request)
    {
        $product = $this->productRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $product);

        if ($request->input('submit') === 'save') {
            return redirect()->route('product.list')->with('success_msg', trans('bases::notices.create_success_message'));
        } else {
            return redirect()->route('product.edit', $product->id)->with('success_msg', trans('bases::notices.create_success_message'));
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
        $product = $this->productRepository->findById($id);
        if (empty($product)) {
            abort(404);
        }

        page_title()->setTitle(trans('product::product.edit') . ' #' . $id);

        return view('product::edit', compact('product'));
    }

    /**
     * @param $id
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
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
            return redirect()->route('product.list')->with('success_msg', trans('bases::notices.update_success_message'));
        } else {
            return redirect()->route('product.edit', $id)->with('success_msg', trans('bases::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author TrinhLe
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
                'message' => trans('bases::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('bases::notices.cannot_delete'),
            ];
        }
    }
}
