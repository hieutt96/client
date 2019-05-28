@extends('layouts.app')
@section('title')
	<title>Xác thực bảo mật 2 lớp</title>
@endsection
@section('content')
	<div class="container">
		<div class="col-md-12">
			{{Widget::run('alert')}}
		</div>
		<form action="{{route('user.secury.on.post.verify')}}" method="POST">
			{{csrf_field()}}
			<div class="form-group">
		        <input id="password" type="password" value="{{old('password')}}" required="true" name="password" autocomplete="off"  readonly="" onfocus="this.removeAttribute('readonly');"/>
				<label for="password" alt="Nhập password" placeholder="Nhập password"></label>
		        
		    </div>
			<button class="" type="submit">Xác thực</button>
		</form>
	</div>
@endsection