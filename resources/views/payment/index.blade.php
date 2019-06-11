@extends('layouts.app')
@section('title')
	<title>Trang thanh toán</title>
@endsection
@section('content')
	<div class="container">
		<div class="col-md-12">
			{{Widget::run('alert')}}
		</div>
		
		<div class="col-md-12 text-center">
			<h3>Thanh thanh toán mã đơn hàng : {{$orderId}}</h3>
			<h4>Số tiền là : <b><?= number_format($amount, 0, ',', '.').' VND' ?></b></h4>
		</div>
		<form method="POST" action="{{route('order.post.payment')}}">
			{{ csrf_field() }}
			<div class="col-md-12">
				<h3>Nhập thông tin của bạn</h3>
				<div class="form-group">
			        <input type="text" id="email" required="true" readonly="" onfocus="this.removeAttribute('readonly');" name="email">
			        <label for="email" alt="Nhập email" placeholder="Nhập email"></label>
			    </div>
			    <div class="form-group">
			        <input type="password" id="password" required="true" readonly="" onfocus="this.removeAttribute('readonly');" name="password">
			        <label for="password" alt="Nhập Password" placeholder="Nhập Password"></label>
			    </div>
			    <button type="submit" style="margin-top: 120px;">Submit</button>
			</div>
		</form>
	</div>

@endsection