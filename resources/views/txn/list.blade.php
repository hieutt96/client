@extends('layouts.app')
@section('title')
	<title>Lịch sử giao dịch</title>
	<style type="text/css">
		.notification {

			border-bottom: 0.2px solid black;
			padding: 15px;
		}
		a:hover {
			text-decoration: none;
		}
		a {

		}
	</style>
@endsection
@section('content')
	<div class="container">
		@foreach($notifications as $notification)
			<div class="row" >
				<a href="{{route('txn.detail', $notification->id)}}" data-toggle="tooltip" title="Click để xem chi tiết" style="@if($notification->read_at !== null) color: #1e2325 !important; @endif">
					<p class="notification"><b>{{$notification->data->data}}</b>. Thời gian : <?= date('Y-m-d H:i:s', strtotime($notification->created_at->date)); ?>. Trạng thái: @if($notification->read_at == null) Chưa đọc @else Đã xem @endif</p>
				</a>
			</div>
		@endforeach
	</div>
@endsection