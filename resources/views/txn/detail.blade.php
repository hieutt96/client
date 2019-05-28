@extends('layouts.app')
@section('title')
	<title>Chi tiết giao dịch giao dịch</title>
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
			<div class="row">
				<p class="notification"><b>{{$notification->content}}</b>. Thời gian : <?= date('Y-m-d H:i:s', strtotime($notification->created_at->date)); ?>.</p>
			</div>
	</div>
@endsection