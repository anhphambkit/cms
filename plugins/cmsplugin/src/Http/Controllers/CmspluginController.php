<?php

namespace Plugins\Cmsplugin\Http\Controllers;

use Assets;
use Plugins\Cmsplugin\Http\Requests\CmspluginRequest;
use Plugins\Cmsplugin\Repositories\Interfaces\CmspluginInterface;
use Core\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\Exception;
use Plugins\Cmsplugin\Http\DataTables\CmspluginDataTable;

class CmspluginController extends BaseController
{
    /**
     * @var CmspluginInterface
     */
    protected $cmspluginRepository;

    /**
     * CmspluginController constructor.
     * @param CmspluginInterface $cmspluginRepository
     * @author Sang Nguyen
     */
    public function __construct(CmspluginInterface $cmspluginRepository)
    {
        $this->cmspluginRepository = $cmspluginRepository;
    }

    /**
     * Display all cmsplugin
     * @param CmspluginDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Sang Nguyen
     */
    public function getList(CmspluginDataTable $dataTable)
    {

        page_title()->setTitle(trans('cmsplugin::cmsplugin.list'));

        return $dataTable->renderTable(['title' => trans('cmsplugin::cmsplugin.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Sang Nguyen
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('cmsplugin::cmsplugin.create'));

        return view('cmsplugin::create');
    }

    /**
     * Insert new Cmsplugin into database
     *
     * @param CmspluginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Sang Nguyen
     */
    public function postCreate(CmspluginRequest $request)
    {
        $cmsplugin = $this->cmspluginRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CMSPLUGIN_MODULE_SCREEN_NAME, $request, $cmsplugin);

        if ($request->input('submit') === 'save') {
            return redirect()->route('cmsplugin.list')->with('success_msg', trans('bases::notices.create_success_message'));
        } else {
            return redirect()->route('cmsplugin.edit', $cmsplugin->id)->with('success_msg', trans('bases::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Sang Nguyen
     */
    public function getEdit($id)
    {
        $cmsplugin = $this->cmspluginRepository->findById($id);
        if (empty($cmsplugin)) {
            abort(404);
        }

        page_title()->setTitle(trans('cmsplugin::cmsplugin.edit') . ' #' . $id);

        return view('cmsplugin::edit', compact('cmsplugin'));
    }

    /**
     * @param $id
     * @param CmspluginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Sang Nguyen
     */
    public function postEdit($id, CmspluginRequest $request)
    {
        $cmsplugin = $this->cmspluginRepository->findById($id);
        if (empty($cmsplugin)) {
            abort(404);
        }
        $cmsplugin->fill($request->input());

        $this->cmspluginRepository->createOrUpdate($cmsplugin);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CMSPLUGIN_MODULE_SCREEN_NAME, $request, $cmsplugin);

        if ($request->input('submit') === 'save') {
            return redirect()->route('cmsplugin.list')->with('success_msg', trans('bases::notices.update_success_message'));
        } else {
            return redirect()->route('cmsplugin.edit', $id)->with('success_msg', trans('bases::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author Sang Nguyen
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $cmsplugin = $this->cmspluginRepository->findById($id);
            if (empty($cmsplugin)) {
                abort(404);
            }
            $this->cmspluginRepository->delete($cmsplugin);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CMSPLUGIN_MODULE_SCREEN_NAME, $request, $cmsplugin);

            return [
                'error' => false,
                'message' => trans('bases::notices.deleted'),
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => trans('bases::notices.cannot_delete'),
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @author Sang Nguyen
     */
    public function postDeleteMany(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return [
                'error' => true,
                'message' => trans('bases::notices.no_select'),
            ];
        }

        foreach ($ids as $id) {
            $cmsplugin = $this->cmspluginRepository->findById($id);
            $this->cmspluginRepository->delete($cmsplugin);
            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CMSPLUGIN_MODULE_SCREEN_NAME, $request, $cmsplugin);
        }

        return [
            'error' => false,
            'message' => trans('bases::notices.delete_success_message'),
        ];
    }

    /**
     * @param Request $request
     * @return array
     * @author Sang Nguyen
     */
    public function postChangeStatus(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return [
                'error' => true,
                'message' => trans('bases::notices.no_select'),
            ];
        }

        foreach ($ids as $id) {
            $cmsplugin = $this->cmspluginRepository->findById($id);
            $cmsplugin->status = $request->input('status');
            $this->cmspluginRepository->createOrUpdate($cmsplugin);

            do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CMSPLUGIN_MODULE_SCREEN_NAME, $request, $cmsplugin);
        }

        return [
            'error' => false,
            'status' => $request->input('status'),
            'message' => trans('bases::notices.update_success_message'),
        ];
    }
}
