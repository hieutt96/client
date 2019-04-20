
<html lang="en">
	
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- main css -->
        <link rel="stylesheet" href="{{asset('/css/main.css')}}">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    </head>
    @yield('title')
    <style type="text/css">
    	#logo_home {
    		margin-top: -20px;
    		width: 70px;
    	}
    </style>
    <body>
    	<nav class="navbar navbar-default">	
    		<div class="container">
    			<div class="navbar-header">
    				<a href="{{route('home')}}" class="navbar-brand"><img src="{{asset('/image/default/mywallet.jpg')}}" id="logo_home"></a>
    			</div>
    			<ul class="nav navbar-nav">
    				<li><a href="#">Chuyển tiền</a></li>
    				<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Nạp tiền
				        <span class="caret"></span></a>
				        <ul class="dropdown-menu">
				          <li><a href="#">MOMO</a></li>
				          <li><a href="#">VNPAY</a></li>
				        </ul>
    				</li>
    			</ul>
    			<ul class="nav navbar-nav navbar-right">
    				@if(isset($user))
						<li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $user->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('user.logout')}}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.get.login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('user.get.register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.get.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                    @endif
    			</ul>
    		</div>
    	</nav>
    	<section>
            <div class="container">
                @yield('content')
            </div>
    	</section>
    </body>
</html>