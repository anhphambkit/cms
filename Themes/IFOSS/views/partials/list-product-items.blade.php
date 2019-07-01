<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-29
 * Time: 10:48
 */
?>
@foreach($products as $product)
    <div class="col-md-3">
        @component("components.product-item")
            @slot("productItem", $product)

        @endcomponent
    </div>
@endforeach
