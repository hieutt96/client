$(document).on('click', '.recharge_type', function(){
    var borderActive = $('.recharge_type-active');
    borderActive.removeClass('recharge_type-active');
    borderActive.addClass('recharge_type');
    $(this).addClass('recharge_type-active');
    var chargeType = $(this).data('id');
    $("[name='recharge_type_id']").val(chargeType);
});

$(document).on('click', '.amount', function(){
    var borderActive = $('.amount-active');
    borderActive.removeClass('amount-active');
    borderActive.addClass('amount');
    $(this).addClass('amount-active');
    var amount = $(this).data('id');
    $("[name='amount']").val(amount);
});

