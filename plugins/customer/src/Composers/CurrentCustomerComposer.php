<?php

namespace Plugins\Customer\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CurrentCustomerComposer
{
    /**
     * Compose current account authenticated to views
     * @param  View   $view [description]
     * @return [type]       [description]
     */
    public function compose(View $view)
    {
        $view->with('currentAccount', Auth::guard('customer')->user());
    }
}
