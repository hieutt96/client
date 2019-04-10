<!DOCTYPE html>
<html>
<head>
<title>Đăng ký</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('/css/user/register.css')}}">
</head>
<body>
	@if(Session::get('error'))
		<div class="alert alert-danger">{{Session::get('error')}}</div>
	@endif
	<div class="main-w3layouts wrapper">
		<h1>Đăng ký</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="{{route('user.post.register')}}" method="post">
					@csrf
					<input class="text" type="text" name="username" placeholder="Username" required="true" autocomplete="off">
					<input class="text email" type="email" name="email" placeholder="Email" required="true" autocomplete="off">
					<input class="text" type="password" name="password" placeholder="Password" required="true" autocomplete="off">
					<input class="text w3lpass" type="password" name="confirm_password" placeholder="Confirm Password" required="true" autocomplete="off">
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>Bạn có đồng ý với điều khoản và dịch vụ của chúng tôi !</span>
						</label>
						<div class="clear"> </div>
					</div>
					<input type="submit" value="SIGNUP">
				</form>
				<p>You have an Account? <a href="{{route('user.get.login')}}"> Login Now!</a></p>
			</div>
		</div>
		<div class="colorlibcopy-agile">
			<p>© 2019</p>
		</div>
	</div>
</body>
</html>