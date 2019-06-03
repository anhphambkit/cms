<?php

namespace Core\Base\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Plugins\Cart\Services\CartServices;
use Plugins\Product\Models\ProductCategory;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;

abstract class BasePublicController extends Controller
{
	use DispatchesJobs, ValidatesRequests, AuthorizesRequests;

    /**
     * BasePublicController constructor.
     */
    public function __construct(){
    }
}
