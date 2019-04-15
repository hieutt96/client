@extends('layouts.app')
@section('title')
	<title>Home</title>
@endsection
@section('content')
	@widget('verify_transaction', ['verify_by' => $user->verify_by])
@endsection