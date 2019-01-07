<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;

class UserController extends BaseAdminController{
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show page dashboard admin
     * @return type
     */
    public function index()
    {
        #TODO
        return view('core-user::admin.index');
    }
}