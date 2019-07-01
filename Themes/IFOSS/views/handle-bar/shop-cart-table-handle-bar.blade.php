<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 1/28/19
 * Time: 23:48
 */
?>
@{{#if total_items }}
<div class="row">
    <div class="col-sm-12 col-xl-8">
        <div class="tt-shopcart-table">
            <table>
                <tbody>
                @{{#each products }}
                <tr class="row-product" data-product-id="@{{ id }}">
                    <td>
                        <a href="#" class="tt-btn-close btn-remove-product-in-cart"></a>
                    </td>
                    <td>
                        <div class="tt-product-img">
                            <img src="@{{ featureProduct medias }}" data-src="@{{ featureProduct medias }}" alt="@{{ name }}">
                        </div>
                    </td>
                    <td>
                        <h2 class="tt-title">
                            <a href="@{{ urlProduct slug id }}">@{{ name }}</a>
                        </h2>
                        <div class="tt-price">
                            Giá:
                            <span class="cart-table-price-product">
                                            @{{ formatCurrency price }}
                                        </span>
                        </div>
                    </td>
                    <td>
                        <div class="detach-quantity-desctope">
                            <div class="tt-input-counter style-01">
                                <span class="minus-btn"></span>
                                <input class="input-quantity-product cart-page" type="text" value="@{{ quantity }}" size="9999">
                                <span class="plus-btn"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="tt-price subtotal cart-table-subtotal-product">
                            @{{ formatCurrency price }} đ
                        </div>
                    </td>
                </tr>
                @{{/each}}
                </tbody>
            </table>
            <div class="tt-shopcart-btn">
                <div class="col-left">
                    <a class="btn-link" href="/shop"><i class="icon-e-19"></i>{{ trans('shop.continue_shopping') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-4">
        <div class="tt-shopcart-wrapper">
            <div class="tt-shopcart-box tt-boredr-large">
                <table class="tt-shopcart-table01">
                    <tbody>
                    <tr>
                        <th class="text-uppercase">Tạm tính</th>
                        <td>@{{ formatCurrency total_price }}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-uppercase">Tổng</th>
                        <td>@{{ formatCurrency total_price }}</td>
                    </tr>
                    </tfoot>
                </table>
                <a href="/shop/checkout/shipping" class="btn btn-lg text-uppercase full-width-btn-custom"><span class="icon icon-check_circle"></span>{{ trans('shop.proceed_to_checkout') }}</a>
            </div>
        </div>
    </div>
</div>
@{{else}}
<!-- layout emty cart -->
<div class="tt-empty-cart">
    <span class="tt-icon icon-f-39"></span>
    <h1 class="tt-title text-uppercase">Giỏ hàng rỗng</h1>
    <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
    <a href="/shop" class="btn text-uppercase">Tiếp tục mua sắm</a>
</div>
@{{/if}}
