@extends('layouts.app')
@section('title')
	<title>Xác nhận chuyển tiền</title>
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

	</style>
@endsection
@section('content')
	<div class="container">
		<center>
			<table class="">
				<tr>
					<td>Chuyển đến </td>
					<td>{{$dataTransfer['email']}}</td>
				</tr>
				<tr>
					<td>Số tiền</td>
					<td><?= number_format($dataTransfer['amount'], 0, ',', '.') ?></td>
				</tr>
				<tr>
					<td>
						Phí giao dịch
					</td>
					<td>
						<?= number_format($dataTransfer['fee'], 0, ',', '.') ?>
					</td>
				</tr>
				<tr>
					<td>Nội dung</td>
					<td>{{$dataTransfer['description']}}</td>
				</tr>
			</table>
			<div class="col-md-12">
				<form method="POST" action="{{route('transfer.post.verify')}}">
					{{csrf_field()}}
					<div class="form-group">
						<input type="password" name="password" value="" autocomplete="off" id="password" required="true">
						<label for="password" alt="Nhập Password" placeholder="Nhập Password"></label>
					</div>
					<button type="submit" style="margin-top: 100px;">Xác nhận giao dịch</button>
				</form>
			</div>
		</center>
	</div>
@endsection