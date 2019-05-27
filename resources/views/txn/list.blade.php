@extends('layouts.app')
@section('title')
	<title>Lịch sử giao dịch</title>
@endsection
@section('content')
	<div class="container">
		@foreach($notifications as $notification)
			@if($notification->read_at == null) 
				<div class="row junbotron">
					{{}}
				</div>
			@else
				<div class="row">
					
				</div>
			@endif
		@endforeach
	</div>
@endsection