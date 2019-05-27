@extends('layouts.app')
@section('title')
	<title>Cài đặt</title>
@endsection
@section('content')
	<div class="container">
		<div class="col-md-12">
			{{ Widget::run('alert')}}
		</div>
		<div class="col-md-12">
			<table class="table table-hover table-border">
				<tr>
					<td>Email</td>
					<td>{{$data->email}}</td>
				</tr>
				<tr>
					<td>Phone</td>
					<td>{{$data->phone}}</td>
				</tr>
				<tr>
					<td>Địa chỉ</td>
					<td>{{$data->address}}</td>
				</tr>
				<tr>
					<td>Trạng thái</td>
					@if($data->active)
						<td><label class="label label-success">Active</label></td>
					@else
						<td><label class="label label-danger">Block</label></td>
					@endif
				</tr>
				<tr>
					<td>Mã Google Authenticate</td>
					<td>
						@if(isset($data->secret))
							<td>{{$data->secret}}</td>
						@else
							<td></td>
						@endif
					</td>
				</tr>
				<tr>
					<td>Thời gian lập tài khoản</td>
					<td><?= date('Y-m-d H:i:s', strtotime($data->created_at->date)) ?></td>
				</tr>
				<tr>
					<td>Bảo mật 2 lớp</td>
					@if($data->status == '00')
						<td>Off</td>
					@else
						<td>On</td>
					@endif
				</tr>
			</table>
			
		</div>

		<div class="col-md-12">
			<div class="col-md-6">
				@if($data->status == '00') 
					<a href="{{route('user.secury.on')}}"><button type="button">Bật bảo mật 2 lớp</button></a>
				@else 
					<a href="#"><button type="button">Tắt bảo mật 2 lớp</button></a>
				@endif
			</div>
			<div class="col-md-6">
				<a href="{{route('user.edit')}}"><button class="btn" type="submit">Cập nhập thông tin</button></a>
			</div>
			
		</div>
	</div>
@endsection