@extends('layouts.app')
@section('title')
	<title>Chỉnh sửa</title>
@endsection
@section('content')
	<div class="container">
		<div class="col-md-12">
			{{ Widget::run('alert') }}
		</div>
		<div class="col-md-12">
			<form method="POST" action="{{route('user.post.edit')}}">
				@csrf
				{{ csrf_field() }}
				<div class="form-group">
					<label class="label-control">Địa chỉ</label>
					<textarea rows="5" name="address" class="form-control" value="{{ old('address') }}"></textarea>
				</div>
				<div class="form-group">
					<label class="label-control">Số điện thoại</label>
					<input type="text" name="phone" value="{{old('phone')}}">
				</div>
				<div class="form-group">
					<label class="label-control">CMND/Căn cước</label>
					<input type="text" name="social_id" value="{{old('social_id')}}">
				</div>
				<button class="" type="submit">Submit</button>
			</form>
		</div>
	</div>
@endsection