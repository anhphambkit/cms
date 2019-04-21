<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-21
 * Time: 12:27
 */

namespace Plugins\Product\Controllers\Ajax\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

class ProductController extends BaseAdminController
{
    public function getProductsByCategory(Request $request) {
        $categoryId = $request->get('category_id');
    }
}