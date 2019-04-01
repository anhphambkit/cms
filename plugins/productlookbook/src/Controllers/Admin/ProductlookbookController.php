<?php

namespace Plugins\Productlookbook\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Productlookbook\Requests\ProductlookbookRequest;
use Plugins\Productlookbook\Repositories\Interfaces\ProductlookbookRepositories;
use Plugins\Productlookbook\DataTables\ProductlookbookDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class ProductlookbookController extends BaseAdminController
{
    /**
     * @var ProductlookbookRepositories
     */
    protected $productlookbookRepository;

    /**
     * ProductlookbookController constructor.
     * @param ProductlookbookRepositories $productlookbookRepository
     * @author TrinhLe
     */
    public function __construct(ProductlookbookRepositories $productlookbookRepository)
    {
        $this->productlookbookRepository = $productlookbookRepository;
    }

    /**
     * Display all productlookbook
     * @param ProductlookbookDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(ProductlookbookDataTable $dataTable)
    {

        // page_title()->setTitle(trans('productlookbook::productlookbook.list'));

        return $dataTable->renderTable(['title' => trans('plugins-productlookbook::productlookbook.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        // page_title()->setTitle(trans('productlookbook::productlookbook.create'));

        return view('productlookbook::create');
    }

    /**
     * Insert new Productlookbook into database
     *
     * @param ProductlookbookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(ProductlookbookRequest $request)
    {
        $productlookbook = $this->productlookbookRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCTLOOKBOOK_MODULE_SCREEN_NAME, $request, $productlookbook);

        if ($request->input('submit') === 'save') {
            return redirect()->route('productlookbook.list')->with('success_msg', trans('bases::notices.create_success_message'));
        } else {
            return redirect()->route('productlookbook.edit', $productlookbook->id)->with('success_msg', trans('bases::notices.create_success_message'));
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
        $productlookbook = $this->productlookbookRepository->findById($id);
        if (empty($productlookbook)) {
            abort(404);
        }

        // page_title()->setTitle(trans('productlookbook::productlookbook.edit') . ' #' . $id);

        return view('productlookbook::edit', compact('productlookbook'));
    }

    /**
     * @param $id
     * @param ProductlookbookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, ProductlookbookRequest $request)
    {
        $productlookbook = $this->productlookbookRepository->findById($id);
        if (empty($productlookbook)) {
            abort(404);
        }
        $productlookbook->fill($request->input());

        $this->productlookbookRepository->createOrUpdate($productlookbook);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCTLOOKBOOK_MODULE_SCREEN_NAME, $request, $productlookbook);

        if ($request->input('submit') === 'save') {
            return redirect()->route('productlookbook.list')->with('success_msg', trans('bases::notices.update_success_message'));
        } else {
            return redirect()->route('productlookbook.edit', $id)->with('success_msg', trans('bases::notices.update_success_message'));
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
            $productlookbook = $this->productlookbookRepository->findById($id);
            if (empty($productlookbook)) {
                abort(404);
            }
            $this->productlookbookRepository->delete($productlookbook);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCTLOOKBOOK_MODULE_SCREEN_NAME, $request, $productlookbook);

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
