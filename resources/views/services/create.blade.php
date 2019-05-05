@extends('layouts.app')
@section('title')
	<title>Dịch vụ VAT</title>
@endsection
@section('content')
	<link rel="stylesheet" type="text/css" href="{{asset('css/vat/create.css')}}">
	<div class="container">	
		<div class="col-md-12">
			{{ Widget::run('alert') }}
		</div>
		<div class="col-md-12">
			<form method="POST" action="{{route('service.buy.item')}}">
				{{ csrf_field() }}
				<div class="col-md-12 col-xs-12">
					<h3>Chọn loại thẻ</h3>
				</div>
				<br>
				<div class="col-md-12 col-xs-12 method">
					@if(count($serviceItems))
						@foreach($serviceItems as $key => $item)
							@if($loop->first)
								<div class="col-md-4 col-xs-4 method">
									<div class="col-md-10 col-xs-10 item-active" data-id={{$item->code}}>
										<center><img class="logo_type" src="<?= '/image/vat/items/'.$item->code ?>"></center>
									</div>
								</div>
								<input type="hidden" name="item_id" value="{{$item->services_id}}">
							@else 
								<div class="col-md-4 col-xs-4 method">
									<div class="col-md-10 col-xs-10 item" data-id={{$item->code}}>
										<center><img class="logo_type" src="<?= '/image/vat/items/'.$item->code ?>"></center>
									</div>
								</div>
							@endif
						@endforeach
					@endif
				</div>
				<br>
				<div class="col-md-12 col-xs-12">
					<h3>Chọn mệnh giá</h3>
				</div>
				<br>
				<div class="col-md-12 col-xs-12 method">
					
				</div>
			</form>
		</div>
	</div>

@endsection