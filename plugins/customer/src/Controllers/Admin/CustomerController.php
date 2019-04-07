<?php

namespace Plugins\Customer\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Customer\Requests\CustomerRequest;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\DataTables\CustomerDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class CustomerController extends BaseAdminController
{
    /**
     * @var CustomerRepositories
     */
    protected $customerRepository;

    /**
     * CustomerController constructor.
     * @param CustomerRepositories $customerRepository
     * @author TrinhLe
     */
    public function __construct(CustomerRepositories $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display all customer
     * @param CustomerDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(CustomerDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-customer::customer.list'));

        return $dataTable->renderTable(['title' => trans('plugins-customer::customer.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-customer::customer.create'));

        return view('plugins-customer::create');
    }

    /**
     * Insert new Customer into database
     *
     * @param CustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(CustomerRequest $request)
    {
        $customer = $this->customerRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customer);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.customer.edit', $customer->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $customer = $this->customerRepository->findById($id);
        if (empty($customer)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-customer::customer.edit') . ' #' . $id);

        return view('plugins-customer::edit', compact('customer'));
    }

    /**
     * @param $id
     * @param CustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, CustomerRequest $request)
    {
        $customer = $this->customerRepository->findById($id);
        if (empty($customer)) {
            abort(404);
        }
        $customer->fill($request->input());

        $this->customerRepository->createOrUpdate($customer);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customer);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.customer.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $customer = $this->customerRepository->findById($id);
            if (empty($customer)) {
                abort(404);
            }
            $this->customerRepository->delete($customer);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customer);

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
