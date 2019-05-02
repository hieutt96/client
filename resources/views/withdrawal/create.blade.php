@extends('layouts.app')
@section('title')
	<title> Rút tiền </title>
@endsection
@section('content')
	{{Widget::run('alert')}}
	<link rel="stylesheet" type="text/css" href="{{asset('css/withdrawal/create.css')}}">
	<form method="POST" action="{{route('user.post.withdrawal')}}" class="form">
		{{csrf_field()}}
		<div class="col-md-12 col-xs-12">
			<h3>Chọn phương thức</h3>
		</div>
		<br>
		<div class="col-md-12 col-xs-12 method">
			@if(($types))
				@foreach($types as $key => $value)
					@if($loop->first)
						<div class="col-md-4 col-xs-4">
							<div class="col-md-10 col-xs-10 withdrawal_type-active" data-id={{$value}}>
								<center><img class="logo_type" src="<?= '/image/default/'.$value.'.png' ?>"></center>
							</div>
						</div>
						<input type="hidden" name="withdrawal_type_id" value="{{$value}}">
					@else 
						<div class="col-md-4 col-xs-4">
							<div class="col-md-10 col-xs-10 withdrawal_type" data-id={{$value}}>
								<center><img class="logo_type" src="<?= '/image/default/'.$value.'.png' ?>"></center>
							</div>
						</div>
					@endif
				@endforeach
			@endif
		</div>
		<div class="divide"></div>
		<h3>Chọn số tiền</h3>
		<div class="col-md-12 col-xs-12">
			@if(count($amounts)) 
				@foreach($amounts as $key => $value)
					@if($loop->first)
						<div class="col-md-4 col-xs-4">
							<div class="col-md-10 col-xs-10 amount-active" data-id={{$value}}>
								<center><?= number_format($value, 0, ',', '.') ?></center>
							</div>
						</div>
						<input type="hidden" name="amount" value="{{$value}}">
					@else 
						<div class="col-md-4 col-xs-4">
							<div class="col-md-10 col-xs-10 amount" data-id={{$value}}>
								<center><?= number_format($value, 0, ',', '.') ?></center>
							</div>
						</div>
					@endif
				@endforeach
			@endif
		</div>
		<button class="btn">Submit</button>
	</form>
	<script type="text/javascript" src="{{asset('js/withdrawl/create.js')}}"></script>	
@endsection