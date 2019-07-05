@{{#if total_items }}
    <div class="product-list mb-2">
        @{{#each products }}
        <div class="item">
            <div class="mini-thumbnail-cart"><img src="{{ asset('assets/images/products/product-chair-' . $i . '.jpg') }}" /></div>
            <div class="quantity">x>@{{ (getQuantityProduct @root.quantities id) }} <br> <span class="font-weight-500">$@{{ formatCurrency price }}</span></div>
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
            <div class="input-group mb-3">
                <input type="text" class="form-control rounded-0" placeholder="Enter your code here">
                <div class="input-group-append">
                    <button class="btn btn-secondary rounded-0" type="button">apply</button>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('public.cart') }}">
                    <button class="btn btn-outline-custom rounded-0 btn-sm w-50 justify-content-center mr-1">Go to Cart</button>
                </a>
                <a href="{{ route('public.product.checkout') }}">
                    <button class="btn btn-outline-custom rounded-0 btn-sm w-50 justify-content-center ml-1">Checkout</button>
                </a>
            </div>
        </div>
    </div>
@{{else}}
    <!-- layout emty cart -->
    <a href="#" class="tt-cart-empty">
        <i class="icon-f-39"></i>
        <p>Empty!</p>
    </a>
@{{/if}}