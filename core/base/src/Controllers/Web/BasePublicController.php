<?php

namespace Core\Base\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Core\User\Repositories\Interfaces\Authentication;

abstract class BasePublicController extends Controller
{
    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct()
    {
        $this->auth = app(Authentication::class);
    }
}
