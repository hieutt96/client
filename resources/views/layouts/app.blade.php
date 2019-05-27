
<html lang="en">
	
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- main css -->
        <link rel="stylesheet" href="{{asset('/css/main.css')}}">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="{{asset('/css/lib/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/lib/font-awesome.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/lib/font-awesome.min.css')}}">
        <script type="text/javascript" src="{{asset('/js/lib/jquery.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/lib/bootstrap.js')}}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    @yield('title')
    <style type="text/css">
    	#logo_home {
    		margin-top: -20px;
    		width: 70px;
    	}
        .navbar.navbar-default {
            padding: 10px;
        }
    </style>
    <body>
    	<nav class="navbar navbar-default">	
    		<div class="container">
    			<div class="navbar-header">
    				<a href="{{route('home')}}" class="navbar-brand"><img src="{{asset('/image/default/mywallet.jpg')}}" id="logo_home"></a>
    			</div>
    			<ul class="nav navbar-nav">
    				<li><a href="{{route('transfer.create')}}">Chuyển tiền</a></li>
    				<li class="dropdown">
    					<a href="{{route('user.recharge')}}">Nạp tiền</a>
    				</li>
                    <li class="dropdown">
                        <a href="{{route('withdrawal.create')}}">Rút tiền</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">About
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">Page 1</a></li>
                          <li><a href="#">Page 2</a></li>
                        </ul>
                    </li>
    			</ul>
                
    			<ul class="nav navbar-nav navbar-right">
    				@if(isset($user))
                        <li class="navbar-item">
                            <a href="#" style="cursor: pointer;">Số dư : <b><?= number_format($user->balance, 0, ',', '.') .'  VND'?></b></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('txn.list.notification')}}"><i class="fa fa-bell-o fa-big"><span class="label label-danger">{{$user->notification_unread}}</span></i></a>
                        </li>
						<li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $user->name }} <span class="caret"></span>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{route('user.google2FA')}}" class="dropdown-item">Profile</a>
                                <div class="divider"></div>
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