<?php

namespace Plugins\Payment\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Payment\Requests\PaymentRequest;
use Plugins\Payment\Repositories\Interfaces\PaymentRepositories;
use Plugins\Payment\DataTables\PaymentDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class PaymentController extends BaseAdminController
{
    /**
     * @var PaymentRepositories
     */
    protected $paymentRepository;

    /**
     * PaymentController constructor.
     * @param PaymentRepositories $paymentRepository
     * @author TrinhLe
     */
    public function __construct(PaymentRepositories $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Display all payment
     * @param PaymentDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(PaymentDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-payment::payment.list'));

        return $dataTable->renderTable(['title' => trans('plugins-payment::payment.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-payment::payment.create'));

        return view('plugins-payment::create');
    }

    /**
     * Insert new Payment into database
     *
     * @param PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(PaymentRequest $request)
    {
        $payment = $this->paymentRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PAYMENT_MODULE_SCREEN_NAME, $request, $payment);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.payment.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.payment.edit', $payment->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $payment = $this->paymentRepository->findById($id);
        if (empty($payment)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-payment::payment.edit') . ' #' . $id);

        return view('plugins-payment::edit', compact('payment'));
    }

    /**
     * @param $id
     * @param PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, PaymentRequest $request)
    {
        $payment = $this->paymentRepository->findById($id);
        if (empty($payment)) {
            abort(404);
        }
        $payment->fill($request->input());

        $this->paymentRepository->createOrUpdate($payment);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PAYMENT_MODULE_SCREEN_NAME, $request, $payment);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.payment.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.payment.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $payment = $this->paymentRepository->findById($id);
            if (empty($payment)) {
                abort(404);
            }
            $this->paymentRepository->delete($payment);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PAYMENT_MODULE_SCREEN_NAME, $request, $payment);

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
