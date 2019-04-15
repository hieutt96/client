<link rel="stylesheet" type="text/css" href="{{asset('/css/user/login.css')}}">
<form method="POST" action="{{route('user.post.login')}}" autocomplete="off">
	{{ csrf_field()}}
	<div class="login-page">
	  <div class="form">
	    <form class="login-form">
	    	<input type="text" placeholder="email address" name="email" />
	        <input type="password" placeholder="password" name="password" />
	        <button>Login</button>
	        <p class="message">Already registered? <a href="{{route('user.get.register')}}">Sign In</a></p>
	    </form>
	  </div>
	</div>
</form>
<script type="text/javascript">
	$('.message a').click(function(){
	   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
	});
</script>