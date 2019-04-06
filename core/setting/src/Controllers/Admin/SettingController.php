<?php

namespace Core\Setting\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController as BaseController;
use Illuminate\Http\Request;
use Setting;

class SettingController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getOptions()
    {
        page_title()->setTitle(trans('core-setting::setting.title'));

        $settings = Setting::getConfig();
        return view('core-setting::option', compact('settings'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getSystems()
    {
        page_title()->setTitle(trans('core-setting::setting.title'));

        $settings = Setting::getConfig();
        return view('core-setting::system', compact('settings'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function postSystems()
    {
       
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postOptions(Request $request)
    {
        $settings = Setting::getConfig();

        foreach ($settings as $tab) {
            foreach ($tab['settings'] as $setting) {
                $key = $setting['attributes']['name'];
                Setting::set($key, $request->input($key, 0));
            }
        }

        Setting::save();
        if ($request->input('submit') === 'save') {
            return redirect()->route('settings.options')->with('success_msg', trans('bases::notices.update_success_message'));
        } else {
            return redirect()->back()->with('success_msg', trans('bases::notices.update_success_message'));
        }
    }
}
