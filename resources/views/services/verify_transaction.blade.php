@extends('layouts.app')
@section('title')
	<title>Xác thực tài khoản</title>
@endsection
@section('content')
	<div class="container">
		<div class="col-md-12">
			{{Widget::run('alert')}}
		</div>
		<h3>Nhập thông tin tài khoản tài khoản ví của bạn</h3>
		<form action="{{route('post.service.verify')}}" method="POST">
			{{csrf_field()}}
			@if($email) 
				<div class="form-group">
			        <input id="email" type="text" value="{{old('email')}}" required="true" name="email" autocomplete="off"  readonly="" onfocus="this.removeAttribute('readonly');"/>
					<label for="email" alt="Nhập Email" placeholder="Nhập Email"></label>
			        
			    </div>
			@endif
			<div class="form-group">
		        <input id="password" type="password" value="{{old('password')}}" required="true" name="password" autocomplete="off"  readonly="" onfocus="this.removeAttribute('readonly');"/>
				<label for="password" alt="Nhập password" placeholder="Nhập password"></label>
		        
		    </div>
			<button class="" type="submit">Xác thực</button>
		</form>
	</div>
@endsection