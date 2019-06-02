<?php

namespace Plugins\Cart\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Cart\Requests\CartRequest;
use Plugins\Cart\Repositories\Interfaces\CartRepositories;
use Plugins\Cart\DataTables\CartDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class CartController extends BaseAdminController
{
    /**
     * @var CartRepositories
     */
    protected $cartRepository;

    /**
     * CartController constructor.
     * @param CartRepositories $cartRepository
     * @author TrinhLe
     */
    public function __construct(CartRepositories $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Display all cart
     * @param CartDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(CartDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-cart::cart.list'));

        return $dataTable->renderTable(['title' => trans('plugins-cart::cart.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-cart::cart.create'));

        return view('plugins-cart::create');
    }

    /**
     * Insert new Cart into database
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(CartRequest $request)
    {
        $cart = $this->cartRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CART_MODULE_SCREEN_NAME, $request, $cart);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.cart.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.cart.edit', $cart->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $cart = $this->cartRepository->findById($id);
        if (empty($cart)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-cart::cart.edit') . ' #' . $id);

        return view('plugins-cart::edit', compact('cart'));
    }

    /**
     * @param $id
     * @param CartRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, CartRequest $request)
    {
        $cart = $this->cartRepository->findById($id);
        if (empty($cart)) {
            abort(404);
        }
        $cart->fill($request->input());

        $this->cartRepository->createOrUpdate($cart);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CART_MODULE_SCREEN_NAME, $request, $cart);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.cart.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.cart.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $cart = $this->cartRepository->findById($id);
            if (empty($cart)) {
                abort(404);
            }
            $this->cartRepository->delete($cart);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CART_MODULE_SCREEN_NAME, $request, $cart);

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
