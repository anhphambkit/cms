<?php
/**
 * Created by PhpStorm.
 * User: anh.pham
 * Date: 4/29/2019
 * Time: 3:33 PM
 */

namespace Plugins\Product\Contracts;


interface ProductReferenceConfig
{
    /* Reference look book */
    const REFERENCE_LOOK_BOOK_TYPE_LAYOUT               = 'TYPE_LOOK_BOOK_LAYOUT';
    const REFERENCE_LOOK_BOOK_TYPE_LAYOUT_NORMAL        = 'Normal';
    const REFERENCE_LOOK_BOOK_TYPE_LAYOUT_VERTICAL      = 'Vertical';

    const PRODUCT_TYPE_SIMPLE                           = 'simple';
    const PRODUCT_TYPE_VARIANT                          = 'variants';
    const PRODUCT_TYPE_CHILD_VARIANT                    = 'child_variant';

    const ENTITY_CLASS_PRODUCT                           = 'Plugins\Product\Models\Product';
    const ENTITY_CLASS_LOOK_BOOK                         = 'Plugins\Product\Models\LookBook';

    const ENTITY_TYPE_PRODUCT                           = 'products';
    const ENTITY_TYPE_LOOK_BOOK                         = 'look_books';
}
