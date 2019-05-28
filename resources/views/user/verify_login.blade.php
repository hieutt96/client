@extends('layouts.app')
@section('title')
	<title>Xác thực bước 2</title>
@endsection
@section('content')
	<div class="container">
		<div class="col-md-12">
			{{Widget::run('alert')}}
		</div>
		<form action="{{route('user.verify_login')}}" method="POST">
			{{csrf_field()}}
			<div class="form-group">
		        <input id="verify_code" type="text" value="{{old('verify_code')}}" required="true" name="verify_code" autocomplete="off"  readonly="" onfocus="this.removeAttribute('readonly');"/>
				<label for="verify_code" alt="Nhập Mã Google Authenticate" placeholder="Nhập Google Authenticate"></label>
		        
		    </div>
			<button class="" type="submit">Xác thực</button>
		</form>
	</div>
@endsection