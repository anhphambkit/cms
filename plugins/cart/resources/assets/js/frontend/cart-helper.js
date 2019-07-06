import { HandlebarRender } from '@coreComponents/base/inc/handlebarForm';
import { Handlebars } from '@pluginComponents/product/product-handlebar';

/* register handlebar */
let miniCart = new HandlebarRender();
miniCart.setSourceElement('#template-mini-cart');
miniCart.setTemplateElement('#mini-cart-header');
miniCart.afterParseTemplate(() => {
    $('[data-toggle="tooltip"]').tooltip();
});

window.updateInfoUICart = function(data) {
    let totalItems = data.total_items;
    if (totalItems > 0) // Update UI cart number
        $('.shopping-cart-quantity i').html(`(${totalItems})`);
    else
        $('.shopping-cart-quantity i').html();

    miniCart.setData(data);
    miniCart.parseTemplate();

    let subTotal = currencyFormat(data.sub_total);
    let total = currencyFormat(data.total_price);
    let saved = currencyFormat(data.saved_price);
    let discount = currencyFormat(data.coupon_discount_amount);
    let wanting = currencyFormat(data.free_design.wanting_price);

    $('.cart-info-total .sub-total-cart').html(`$${subTotal}`);
    $('.cart-info-total .total-price-cart').html(`$${total}`);
    $('.cart-info-total .saved-price-cart').html(`$${saved}`);
    $('.cart-info-total .discount-price').html(`-$${discount}`);
    $('.cart-info-total .wanting-price').html(`+  $${wanting}`);
    $('.cart-info-total .total-free-designs-cart').html(`to qualify for ${data.free_design.total_free_design + 1} FREE DESIGN`);
}

function currencyFormat(num) {
    return (
        num
            .toFixed(0) // always two decimal digits
            .replace('.', ',') // replace decimal point character with ,
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    ) // use . as a separator
};