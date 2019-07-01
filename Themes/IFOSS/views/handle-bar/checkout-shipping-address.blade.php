<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2/23/19
 * Time: 15:10
 */
?>
<h5>Chọn địa chỉ giao hàng:</h5>
<div class="list-address-shipping">
    @{{#each addressBooks}}
        <div class="card card-address card-custom @{{#if is_shipping }} border-dashed-custom @{{/if}}" data-address-id="@{{ id }}">
            {{--<div class="card-header">--}}
                {{--<span class="title-address">--}}
                    {{--@{{ name_address_book }}--}}
                {{--</span>--}}
                {{--@{{#if is_default }}--}}
                    {{--<span class="badge badge-success status-address">--}}
                        {{--Mặc định--}}
                    {{--</span>--}}
                {{--@{{/if}}--}}
            {{--</div>--}}
            <div class="card-body">
                <div class="card-text full-name">
                    <span class="title-custom">
                        Người nhận:
                    </span>
                    <span class="content-custom">
                        @{{ full_name }}
                    </span>
                </div>
                <div class="card-text address">
                    <span class="title-custom">
                        Địa chỉ:
                    </span>
                    <span class="content-custom">
                        @{{ address }}, @{{ province_city_name }}, @{{ district_name }}, @{{ ward_name }}
                    </span>
                </div>
                <div class="card-text email">
                    <span class="title-custom">
                        Email:
                    </span>
                    <span class="content-custom">
                        @{{ email }}
                    </span>
                </div>
                <div class="card-text phone">
                    <span class="title-custom">
                        Điện thoại:
                    </span>
                    <span class="content-custom">
                        @{{ mobile_phone }}
                    </span>
                </div>
                <div class="card-btn-area">
                    <span class="card-action">
                        <a href="#" class="btn btn-small btn-custom-shop btn-ship-to-this-address @{{#unless is_shipping }} btn-black-custom @{{/unless}}">Giao tới địa chỉ này</a>
                    </span>
                    <span class="card-action">
                        <a href="#" class="btn btn-small btn-edit-shop btn-custom-shop btn-edit-shipping-address">Sửa</a>
                    </span>
                    @{{#unless is_default }}
                        <span class="card-action">
                            <a href="#" class="btn btn-small btn-edit-shop btn-custom-shop btn-delete-shipping-address">Xóa</a>
                        </span>
                    @{{/unless}}
                </div>
            </div>
        </div>
    @{{/each}}
</div>
<div class="action-address-shipping-area">
    <span class="guide-custom">
        Bạn muốn giao tới địa chỉ khác?
    </span>
    <span class="action-custom">
        <a href="#" class="btn-link new-shipping-address-action">Thêm địa chỉ giao hàng</a>
    </span>
</div>
