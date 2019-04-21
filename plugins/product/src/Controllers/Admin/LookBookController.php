<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 08:58
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Plugins\Product\DataTables\LookBookDataTable;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use AssetManager;
use AssetPipeline;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;

class LookBookController extends BaseAdminController
{
    /**
     * @var LookBookRepositories
     */
    protected $lookBookRepository;

    /**
     * @var ProductCategoryRepositories
     */
    protected $productCategoryRepositories;

    /**
     * ProductController constructor.
     * @param LookBookRepositories $lookBookRepository
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @author AnhPham
     */
    public function __construct(LookBookRepositories $lookBookRepository, ProductCategoryRepositories $productCategoryRepositories)
    {
        $this->lookBookRepository = $lookBookRepository;
        $this->productCategoryRepositories = $productCategoryRepositories;
    }

    /**
     * Display all look_book
     * @param LookBookDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(LookBookDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::look_book.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::look_book.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $categories = $this->productCategoryRepositories->pluck('name', 'id');

        $products = [];

        page_title()->setTitle(trans('plugins-product::look_book.create'));

        $this->addDetailAssets();

        return view('plugins-product::look-book.create', compact('categories', 'products'));
    }

    /**
     * Insert new Product into database
     *
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postCreate(Request $request)
    {
        $look_book = $this->lookBookRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $look_book);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.look_book.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.look_book.edit', $look_book->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $look_book = $this->lookBookRepository->findById($id);
        if (empty($look_book)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::look_book.edit') . ' #' . $id);

        $this->addDetailAssets();

        return view('plugins-product::look-book.edit', compact('look_book'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postEdit($id, Request $request)
    {
        $look_book = $this->lookBookRepository->findById($id);
        if (empty($look_book)) {
            abort(404);
        }
        $look_book->fill($request->input());

        $this->lookBookRepository->createOrUpdate($look_book);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $look_book);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.look_book.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.look_book.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $look_book = $this->lookBookRepository->findById($id);
            if (empty($look_book)) {
                abort(404);
            }
            $this->lookBookRepository->delete($look_book);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $look_book);

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

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/plugins/product/css/select2/select2.min.css');
        AssetManager::addAsset('look-book-component-css', 'backend/core/base/assets/css/look-book-component.css');

        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('cropper-js', '//cdnjs.cloudflare.com/ajax/libs/cropper/0.7.9/cropper.min.js');
        AssetManager::addAsset('look-book-js', 'backend/plugins/product/assets/js/look-book.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('look-book-component-css');

        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('cropper-js');
        AssetPipeline::requireJs('look-book-js');
    }
}