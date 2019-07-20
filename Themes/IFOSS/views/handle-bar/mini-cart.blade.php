@{{#if total_items }}
    <div class="product-list mb-2">
        @{{#each products }}
        <div class="item">
            <div class="mini-thumbnail-cart"><img src="@{{ image_feature }}" /></div>
            <div class="quantity">x@{{ getQuantityProduct @root.quantities id }}
                <br />
                @{{#ifNotEquals type_product 'variants' }}
                    <span class="font-weight-500">$@{{#if is_has_sale }} @{{ formatCurrency sale_price }} @{{else}} @{{ formatCurrency price }} @{{/if}}</span>
                @{{else}}
                    <div class="font-size-18">$@{{ formatCurrency min_price }} - $@{{ formatCurrency max_price }}</div>
                @{{/ifNotEquals}}
            </div>
            <div class="name">@{{ name }}</div>
        </div>
        @{{/each}}
    </div>
    <div class="cart-order-info font-weight-500 p-0 mb-0">
        <div class="list-item">
            Subtotal
            <span>$@{{ formatCurrency sub_total }}</span>
        </div>
        <div class="list-item">
            Shipping fee
            <span>FREE</span>
        </div>
        @{{#if coupon_discount_amount }}
            <div class="list-item">
                Discount
                <span class="discount-price">-$@{{ formatCurrency coupon_discount_amount }}</span>
            </div>
        @{{/if}}
        <div class="list-item">
            Tax
            <span>$0</span>
        </div>
        <hr class="my-1">
        <div class="list-item">
            Total
            <span>$@{{ formatCurrency total_price }}</span>
        </div>
        <hr>
        <div class="font-weight-500 mb-0" style="background: rgba(150,196,189,.2); margin: -15px; padding: 15px;">
            <div class="mb-2">Coupon DISCOUNT</div>
            <div class="input-group mb-3 coupon-form">
                <input type="text" class="form-control rounded-0 coupon_code" placeholder="Enter your code here" id="mini_coupon_code" name="coupon_code">
                <div class="input-group-append">
                    <button class="btn btn-secondary rounded-0 add-coupon-btn" id="add-coupon-btn-mini-cart" type="button">apply</button>
                </div>
            </div>
            <div class="coupon-in-use">
                @{{#if coupon }}
                    <div class="row coupon-@{{ coupon.id }}">
                        <div class="text-uppercase mb-2 col-md-8 coupon-code-text">@{{ coupon.code }}</div>
                        <div class="text-uppercase mb-2 col-md-4">
                            <a class="action-delete-coupon delete-coupon-@{{ coupon.id }}" data-coupon-id="@{{ coupon.id }}">
                                <i class="far fa-trash-alt icon-action-delete-coupon"></i>
                                Delete
                            </a>
                        </div>
                    </div>
                @{{/if}}
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('public.cart') }}" class="w-50">
                    <button class="btn btn-outline-custom rounded-0 btn-sm w-100 justify-content-center mr-1">Go to Cart</button>
                </a>
                <a href="{{ route('public.product.checkout') }}" class="w-50">
                    <button class="btn btn-outline-custom rounded-0 btn-sm w-100 justify-content-center ml-1">Checkout</button>
                </a>
            </div>
        </div>
    </div>
@{{else}}
    <!-- layout emty cart -->
    <div class="tt-cart-empty text-custom">
        <i class="fas fa-shopping-cart"></i>
        <p>Empty Cart!</p>
    </div>
@{{/if}}