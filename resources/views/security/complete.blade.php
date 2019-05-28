@extends('layouts.app')
@section('title')
	<title>Xác thực bảo mật 2 lớp</title>
@endsection
@section('content')
	<div class="container">
		<div class="col-md-12">
			{{Widget::run('alert')}}
		</div>
		<div class="col-md-12">
			<a href="{{route('user.google2FA')}}"><i class="fa fa-arrow-left">  Back</i></a>
		</div>
		<hr>
		<div class="col-md-12">
			<p>Mã Google Authenticate của bạn là : <b>{{$data->secret}}</b></p>
		</div>
		<div class="col-md-12">
			<h3>QR Code</h3>
			<img src="{{$data->url}}">
		</div>
	</div>
@endsection