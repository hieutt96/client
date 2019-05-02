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
					<td>Chuyển đến </td>
					<td>{{$dataTransfer->email}}</td>
				</tr>
				<tr>
					<td>Số tiền</td>
					<td><?= number_format($dataTransfer->amount, 0, ',', '.') ?></td>
				</tr>
				<tr>
					<td>
						Phí giao dịch
					</td>
					<td>
						<?= number_format($dataTransfer->fee, 0, ',', '.') ?>
					</td>
				</tr>
				<tr>
					<td>Nội dung</td>
					<td>{{$dataTransfer->description}}</td>
				</tr>
			</table>
			<div class="col-md-12" style="margin-top: 100px;">
				<div class="col-md-6">
					<a href="{{route('home')}}"><button class="btn btn-default form-control">Về trang chủ</button></a>
				</div>
				<div class="col-md-6">
					<a href="{{route('transfer.create')}}"><button class="btn btn-success form-control">Giao dịch mới</button></a>
				</div>
			</div>
		</center>
	</div>
@endsection