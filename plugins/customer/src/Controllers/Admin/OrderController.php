<?php

namespace Plugins\Customer\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Customer\Requests\OrderRequest;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Plugins\Customer\DataTables\OrderDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class OrderController extends BaseAdminController
{
    /**
     * @var OrderRepositories
     */
    protected $orderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepositories $orderRepository
     * @author TrinhLe
     */
    public function __construct(OrderRepositories $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display all order
     * @param OrderDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(OrderDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-customer::order.list'));
        return $dataTable->render('plugins-customer::order.index');
        // return $dataTable->renderTable(['title' => trans('plugins-customer::order.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-customer::order.create'));

        return view('plugins-customer::create');
    }

    /**
     * Insert new Order into database
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(OrderRequest $request)
    {
        $order = $this->orderRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.order.edit', $order->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $order = $this->orderRepository->findById($id);
        if (empty($order)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-customer::order.edit') . ' #' . $id);

        return view('plugins-customer::edit', compact('order'));
    }

    /**
     * @param $id
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, OrderRequest $request)
    {
        $order = $this->orderRepository->findById($id);
        if (empty($order)) {
            abort(404);
        }
        $order->fill($request->input());

        $this->orderRepository->createOrUpdate($order);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.order.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $order = $this->orderRepository->findById($id);
            if (empty($order)) {
                abort(404);
            }
            $this->orderRepository->delete($order);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

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
