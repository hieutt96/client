@extends('layouts.app')
@section('title')
	<title>Bảo mật Google Authentication</title>
@endsection
@section('content')
	<img src="{{$url}}">
	<form action="{{route('user.post.google2FA')}}" method="POST">
		{{ csrf_field() }}
		<input type="text" name="secret">
		<button>Click</button>
	</form>
@endsection