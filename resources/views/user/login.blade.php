@extends('layouts.app')
@section('title')
	<title>Login</title>
@endsection
@section('content')
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/site.webmanifest">
    <div class="container">
		<div class="" style="width:50%; margin:0 auto; border: 1px solid white; background-color: #f1f1f1;">
			<div class="col-md-12">
				{{ Widget::run('alert') }}
			</div>
            <center class="col-md-12">
            	<h3 class="card-header" style="margin-top: 40px; margin-bottom: 60px;">Sign In</h3>
            </center>
            <div class="col-md-12">
				<form method="POST" action="{{route('user.post.login')}}">
					@csrf
					{{ csrf_field() }}
				   	<div class="form-group">
				        <input id="email" type="text" required="true" name="email" autocomplete="off" value=""  readonly="" onfocus="this.removeAttribute('readonly');"/>
						<label for="email" alt="Nhập Email" placeholder="Nhập Email"></label>
				        
				    </div>
				    <br>
				    <div class="form-group">
				        <input type="password" id="password" required="true" readonly="" onfocus="this.removeAttribute('readonly');" name="password">
				        <label for="password" alt="Nhập Password" placeholder="Nhập Password"></label>
				    </div>
				    <button type="submit" style="margin-top: 120px;">Submit</button>
				</form>
          	</div>
     	</div>
    </div>
@endsection