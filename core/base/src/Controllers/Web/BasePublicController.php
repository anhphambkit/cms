<?php

namespace Core\Base\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class BasePublicController extends Controller
{
	use DispatchesJobs, ValidatesRequests, AuthorizesRequests;

    /**
     * BasePublicController constructor.
     */
    public function __construct(){

    }
}
