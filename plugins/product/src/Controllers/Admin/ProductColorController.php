<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-09
 * Time: 00:30
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Plugins\Product\DataTables\ProductColorDataTable;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;

class ProductColorController extends BaseAdminController
{
    /**
     * @var ProductColorRepositories
     */
    protected $productColorRepository;

    /**
     * ProductController constructor.
     * @param ProductColorRepositories $productColorRepository
     * @author TrinhLe
     */
    public function __construct(ProductColorRepositories $productColorRepository)
    {
        $this->productColorRepository = $productColorRepository;
    }

    /**
     * Display all color
     * @param ProductColorDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(ProductColorDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::color.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::color.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::color.create'));

        return view('plugins-product::color.create');
    }

    /**
     * Insert new Product into database
     *
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(Request $request)
    {
        $data = $request->input();
        $data['code'] = '#0000';

        $color = $this->productColorRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.color.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.color.edit', $color->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $color = $this->productColorRepository->findById($id);
        if (empty($color)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::color.edit') . ' #' . $id);

        return view('plugins-product::color.edit', compact('color'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, Request $request)
    {
        $color = $this->productColorRepository->findById($id);
        if (empty($color)) {
            abort(404);
        }
        $color->fill($request->input());

        $this->productColorRepository->createOrUpdate($color);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.color.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.color.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $color = $this->productColorRepository->findById($id);
            if (empty($color)) {
                abort(404);
            }
            $this->productColorRepository->delete($color);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

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