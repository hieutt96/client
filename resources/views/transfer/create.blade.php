@extends('layouts.app')
@section('title')
	<title>Chuyển tiền</title>
@endsection
@section('content')
	<div class="container">	
		<div class="col-md-12">
			{{ Widget::run('alert') }}
		</div>
		<div class="col-md-12">
			<form method="POST" action="{{route('transfer.post.create')}}">
				{{ csrf_field() }}
				<div class="form-group">
					<input type="text" name="email" required="true" id="email" value="{{old('email')}}">
					<label for="email" placeholder="Nhập email" alt="Nhập email"></label>
				</div>
				<div class="form-group">
					<input type="text" name="amount" id="amount" required="true" value="{{old('amount')}}">
					<label placeholder="Nhập Số tiền" alt="Nhập Số tiền"></label>
				</div>
				<div class="form-group">
					<textarea class="form-control" rows="5" placeholder="Nhập nội dung chuyển" name="description" value="{{old('description')}}"></textarea>
				</div>
				<div class="form-group">
					<button class="btn" type="submit" style="margin-top: 120px;">Chuyển tiền</button>
				</div>
			</form>
		</div>
	</div>

@endsection