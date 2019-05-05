@extends('layouts.app')
@section('title')
	<title>Home</title>
@endsection
@section('content')
	{{Widget::run('alert')}}
    <div class="container">
        {{ Widget::run('vat') }}
    </div>
@endsection