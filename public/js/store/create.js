$(document).on('click', '.item', function(){
    var borderActive = $('.item-active');
    borderActive.removeClass('item-active');
    borderActive.addClass('item');
    $(this).addClass('item-active');
    var itemId = $(this).data('id');
    $("[name='item_id']").val(itemId);
    if(itemId) {
    	$('#list_amount').html(`<center><img src="/image/default/loading.gif" style="width=100%;"/></center>`);
    	getListAmount(itemId);
    }
});

$(document).on('click', '.amount', function(){
    var borderActive = $('.amount-active');
    borderActive.removeClass('amount-active');
    borderActive.addClass('amount');
    $(this).addClass('amount-active');
    var amount = $(this).data('amount');
    $("[name='amount']").val(amount);
});

$(document).ready(function() {
	var itemId = $("[name='item_id']").val();
	if(itemId) {
		getListAmount(itemId);
	}
});

function getListAmount(itemId) {

	$.ajax({

		url: '/store/service/item/list-amount',
		data: { item_id : itemId},
		dataType: 'json',
		type: 'get',
		success: function(data) {
			if(data) {
				console.log(data.length);
				$("[name='amount']").val(data[0]);
				$("#list_amount").empty();
				for(var i = 0; i < data.length; i++) {
					if(i == 0) {
						$("#list_amount").append(`<div class="col-md-4 col-xs-4 method">
							<div class="col-md-10 col-xs-10 amount-active" data-amount="`+data[i]+`">
								<center>`+data[i]+`</center>
							</div>
						</div>`);
					}else {
						$("#list_amount").append(`<div class="col-md-4 col-xs-4 method">
							<div class="col-md-10 col-xs-10 amount" data-amount="`+data[i]+`">
								<center>`+data[i]+`</center>
							</div>
						</div>`);
					}
					
				}
			}else {
				alert('Có lỗi xảy ra. Vui lòng thử lại sau !');
			}
		},
		error: function() {
			alert('Có lỗi xảy ra. Vui lòng thử lại sau !');
		}
	});
}