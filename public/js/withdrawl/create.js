$(document).on('click', '.withdrawal_type', function(){
    var borderActive = $('.withdrawal_type-active');
    borderActive.removeClass('withdrawal_type-active');
    borderActive.addClass('withdrawal_type');
    $(this).addClass('withdrawal_type-active');
    var chargeType = $(this).data('id');
    $("[name='withdrawal_type_id']").val(chargeType);
});

$(document).on('click', '.amount', function(){
    var borderActive = $('.amount-active');
    borderActive.removeClass('amount-active');
    borderActive.addClass('amount');
    $(this).addClass('amount-active');
    var amount = $(this).data('id');
    $("[name='amount']").val(amount);
});

