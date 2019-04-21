<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-08
 * Time: 23:15
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Plugins\Product\DataTables\ManufacturerDataTable;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;

class ManufacturerController extends BaseAdminController
{
    /**
     * @var ManufacturerRepositories
     */
    protected $manufacturerRepository;

    /**
     * ProductController constructor.
     * @param ManufacturerRepositories $manufacturerRepository
     * @author AnhPham
     */
    public function __construct(ManufacturerRepositories $manufacturerRepository)
    {
        $this->manufacturerRepository = $manufacturerRepository;
    }

    /**
     * Display all manufacturer
     * @param ManufacturerDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ManufacturerDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::manufacturer.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::manufacturer.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::manufacturer.create'));

        return view('plugins-product::manufacturer.create');
    }

    /**
     * Insert new Product into database
     *
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postCreate(Request $request)
    {
        $manufacturer = $this->manufacturerRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $manufacturer);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.manufacturer.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.manufacturer.edit', $manufacturer->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $manufacturer = $this->manufacturerRepository->findById($id);
        if (empty($manufacturer)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::manufacturer.edit') . ' #' . $id);

        return view('plugins-product::manufacturer.edit', compact('manufacturer'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postEdit($id, Request $request)
    {
        $manufacturer = $this->manufacturerRepository->findById($id);
        if (empty($manufacturer)) {
            abort(404);
        }
        $manufacturer->fill($request->input());

        $this->manufacturerRepository->createOrUpdate($manufacturer);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $manufacturer);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.manufacturer.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.manufacturer.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $manufacturer = $this->manufacturerRepository->findById($id);
            if (empty($manufacturer)) {
                abort(404);
            }
            $this->manufacturerRepository->delete($manufacturer);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $manufacturer);

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