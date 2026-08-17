function quantityWiseChangeValue(quantityId, priceId, tdId, price, shippingCharge, productId) {
    addToCart(productId);
    var value = 0;
    var quantityVal = parseInt($('#' + quantityId).val()) + 1;
    $('#' + quantityId).val(quantityVal);
    var total = price * quantityVal;
    $('#' + priceId).val(total);
    $('#' + tdId).html('৳' + total);
    var totalAmount = $("input[name='price[]']")
        .map(function () {
            return $(this).val();
        }).get();

    for (var i = 0; i < totalAmount.length; i++) {
        value += parseInt(totalAmount[i]);
    }


    $('#totalAmount').html('৳' + value);
    $('#totalAmountWithCharge').html('৳' + (value + shippingCharge));

}
