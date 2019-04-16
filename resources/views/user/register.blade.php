@extends('layouts.app')
@section('title')
	<title>Đăng ký</title>
@endsection
@section('content')

	<div class="main-w3layouts wrapper">
		<div class="col-md-12">
			<h1>Đăng ký</h1>
		</div>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<div class="col-md-12">
					{{ Widget::run('alert') }}
				</div>
				<form action="{{route('user.post.register')}}" method="post">
					@csrf
					<div class="col-md-12">
						<input id="username" class="" type="text" name="username" placeholder="Username" value="{{ old('username') }}" autocomplete="off" >
					</div>
					<div class="col-md-12">
						<input id="email" class="" type="text" name="email" value="{{old('email')}}" placeholder="Email"  autocomplete="off">
					</div>
					<div class="col-md-12">
						<input class="text" type="password" name="password" placeholder="Password"  autocomplete="off"  value="{{old('password')}}">
					</div>
					<div class="col-md-12">
						<input class="text" type="password" name="confirm_password" placeholder="Confirm Password"  autocomplete="off" id="confirm_password" value="{{old('confirm_password')}}">
					</div>
					<button type="submit" style="margin-top: 30px;">Đăng ký</button>
				</form>
				<center>You have an Account? <a href="{{route('user.get.login')}}"> Login Now!</a></center>
			</div>
		</div>
		<div class="text-center">
			<p>© 2019</p>
		</div>
	</div>
@endsection