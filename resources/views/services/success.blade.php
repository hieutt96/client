@extends('layouts.app')
@section('title')
	<title>Chuyển tiền thành công</title>
	<style type="text/css">

		tr {
		  height: 60px;
		}

		td {
		  padding: 8px;
		  line-height: 1.42857143;
		  border-top: 1px solid #ddd;
		  font-size: 14px;
		  white-space: nowrap;
		  overflow: hidden;
		  text-overflow: ellipsis;
		  text-align: center;
		}

		table {
		  border-radius: 5px;
		  border-bottom: 20px;
		  max-width: 100%;
		  width: 100%;
		  background-color: #eee;
		  border-spacing: 0;
		  margin-bottom: 20px;
		}

		center {
			width: 75%;
			margin-left: 50px;
		}

		button{

			height: 50px;
		}

		.button {
			margin-bottom: 200px;
		}

	</style>
@endsection
@section('content')
	<div class="container">
		<center class="col-md-12">
			<div class="col-md-12">
				{{Widget::run('alert')}}
			</div>
			<table class="">
				<tr>
					<td>Dịch vụ</td>
					<td>{{$data_response['service']}}</td>
				</tr>
				<tr>
					<td>Loại thẻ</td>
					<td>{{$data_response['param']}}</td>
				</tr>
				<tr>
					<td>
						Số tiền
					</td>
					<td>
						<?= number_format($data_response['amount'], 0, ',', '.').' VND' ?>
					</td>
				</tr>
				<tr>
					<td>Phí</td>
					<td>
						<?= number_format($data_response['fee'], 0, ',', '.'). ' VND' ?>		
					</td>
				</tr>
				<tr>
					<td>Pin</td>
					<td>
						@if($data_response['pin'])
							{{$data_response['pin']}}
						@endif
					</td>
				</tr>
				<tr>
					<td>seri</td>
					<td>
						@if($data_response['seri'])
							{{$data_response['seri']}}
						@endif
					</td>
				</tr>
				<tr>
					<td>Mã giao dịch</td>
					<td>{{$data_response['transaction_id']}}</td>
				</tr>
				<tr>
					<td>Thời gian</td>
					<td>{{$data_response['created_at']}}</td>
				</tr>
			</table>
			<div class="col-md-12 button" style="margin-top: 100px;">
				<div class="col-md-6">
					<a href="{{route('home')}}"><button class="btn btn-default form-control">Về trang chủ</button></a>
				</div>
				<div class="col-md-6">
					<a href="{{route('service.item', $data_response['service_id'])}}"><button class="btn btn-success form-control">Giao dịch mới</button></a>
				</div>
			</div>
		</center>
	</div>
@endsection