
<html lang="en">
	
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- main css -->
        <link rel="stylesheet" href="{{asset('/css/home/style.css')}}">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    @yield('title')
    <style type="text/css">
    	#logo_home {

    		width: 60px;
    		margin-top: 5px;
    		margin-right: 30px;
    	}
    </style>
    <body>    	
        <header class="header_area">
            <div class="main_menu">
            	<nav class="navbar navbar-expand-lg navbar-light">
					<div class="container box_1620">
						<!-- Brand and toggle get grouped for better mobile display -->
						<a class="navbar-brand logo_h" href="{{route('home')}}"><img src="{{asset('/image/default/mywallet.jpg')}}" alt="" id="logo_home"></a>
					
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
							<ul class="nav navbar-nav menu_nav ml-auto">
								<li class="nav-item active"><a class="nav-link" href="">Home</a></li> 
								
								<li class="nav-item"><a class="nav-link" href="">Chuyển tiền</a></li>
								<li class="nav-item submenu dropdown">
									<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nạp tiền</a>
									<ul class="dropdown-menu">
										<li class="nav-item"><a class="nav-link" href="">VnPay</a></li>
										<li class="nav-item"><a class="nav-link" href="">MoMo</a></li>
									</ul>
								</li> 
								<li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								@if(isset($user))
									<li class="nav-item dropdown">
		                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
		                                    {{ $user->name }} <span class="caret"></span>
		                                </a>

		                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
		                                    <a class="dropdown-item">
		                                        {{ __('Logout') }}
		                                    </a>
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
					</div>
            	</nav>
            </div>
        </header>
    	<section>
    		@yield('content')
    	</section>
    </body>
</html>