<?php

namespace Core\Base\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Core\User\Repositories\Interfaces\Authentication;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class BasePublicController extends Controller
{
	use DispatchesJobs, ValidatesRequests, AuthorizesRequests;
    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct()
    {
        $this->auth = app(Authentication::class);
    }
}
