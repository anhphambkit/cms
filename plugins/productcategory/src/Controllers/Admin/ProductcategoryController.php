<?php

namespace Plugins\Productcategory\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Productcategory\Requests\ProductcategoryRequest;
use Plugins\Productcategory\Repositories\Interfaces\ProductcategoryRepositories;
use Plugins\Productcategory\DataTables\ProductcategoryDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class ProductcategoryController extends BaseAdminController
{
    /**
     * @var ProductcategoryRepositories
     */
    protected $productcategoryRepository;

    /**
     * ProductcategoryController constructor.
     * @param ProductcategoryRepositories $productcategoryRepository
     * @author TrinhLe
     */
    public function __construct(ProductcategoryRepositories $productcategoryRepository)
    {
        $this->productcategoryRepository = $productcategoryRepository;
    }

    /**
     * Display all productcategory
     * @param ProductcategoryDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(ProductcategoryDataTable $dataTable)
    {

        // page_title()->setTitle(trans('productcategory::productcategory.list'));

        return $dataTable->renderTable(['title' => trans('plugins-productcategory::productcategory.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        // page_title()->setTitle(trans('productcategory::productcategory.create'));

        return view('productcategory::create');
    }

    /**
     * Insert new Productcategory into database
     *
     * @param ProductcategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(ProductcategoryRequest $request)
    {
        $productcategory = $this->productcategoryRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCTCATEGORY_MODULE_SCREEN_NAME, $request, $productcategory);

        if ($request->input('submit') === 'save') {
            return redirect()->route('productcategory.list')->with('success_msg', trans('bases::notices.create_success_message'));
        } else {
            return redirect()->route('productcategory.edit', $productcategory->id)->with('success_msg', trans('bases::notices.create_success_message'));
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
        $productcategory = $this->productcategoryRepository->findById($id);
        if (empty($productcategory)) {
            abort(404);
        }

        // page_title()->setTitle(trans('productcategory::productcategory.edit') . ' #' . $id);

        return view('productcategory::edit', compact('productcategory'));
    }

    /**
     * @param $id
     * @param ProductcategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, ProductcategoryRequest $request)
    {
        $productcategory = $this->productcategoryRepository->findById($id);
        if (empty($productcategory)) {
            abort(404);
        }
        $productcategory->fill($request->input());

        $this->productcategoryRepository->createOrUpdate($productcategory);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCTCATEGORY_MODULE_SCREEN_NAME, $request, $productcategory);

        if ($request->input('submit') === 'save') {
            return redirect()->route('productcategory.list')->with('success_msg', trans('bases::notices.update_success_message'));
        } else {
            return redirect()->route('productcategory.edit', $id)->with('success_msg', trans('bases::notices.update_success_message'));
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
            $productcategory = $this->productcategoryRepository->findById($id);
            if (empty($productcategory)) {
                abort(404);
            }
            $this->productcategoryRepository->delete($productcategory);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCTCATEGORY_MODULE_SCREEN_NAME, $request, $productcategory);

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
