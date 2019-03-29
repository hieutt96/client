<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Home</title>
        <!-- main css -->
        <link rel="stylesheet" href="{{asset('/css/home/style.css')}}">
        <link rel="stylesheet" href="{{asset('/css/home/responsive.css')}}">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        
        <header class="header_area">
            <div class="main_menu">
            	<nav class="navbar navbar-expand-lg navbar-light">
					<div class="container box_1620">
						<!-- Brand and toggle get grouped for better mobile display -->
						<a class="navbar-brand logo_h" href="index.html"><img src="{{asset('/image/logo.png')}}" alt=""></a>
					
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
							<ul class="nav navbar-nav menu_nav ml-auto">
								<li class="nav-item active"><a class="nav-link" href="">Home</a></li> 
								<!-- <li class="nav-item"><a class="nav-link" href="">Nạp tiền</a></li> -->
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
								<li class="nav-item"><a href="#" class="search"><i class="lnr lnr-magnifier"></i></a></li>
							</ul>
						</div> 
					</div>
            	</nav>
            </div>
        </header>
        <!--================Header Menu Area =================-->
        
        <!--================Home Banner Area =================-->
        <section class="home_banner_area">
            <div class="banner_inner d-flex align-items-center">
				<div class="container">
					<div class="banner_content">
						<h5>The joy of home owning</h5>
						<h3>Find Your New Home</h3>
						<a class="main_btn" href="#">Learn More</a>
					</div>
				</div>
            </div>
            <div class="container">
				<div class="advanced_search">
					<h3>Search Properties for</h3>
					<div class="search_select">
						<select class="s_select">
							<option value="1">Choose Locations</option>
							<option value="2">Property Type</option>
							<option value="4">Bedrooms</option>
						</select>
						<select class="s_select">
							<option value="1">Property Type</option>
							<option value="2">Choose Locations</option>
							<option value="4">Bedrooms</option>
						</select>
						<select class="s_select">
							<option value="1">Bedrooms</option>
							<option value="2">Property Type</option>
							<option value="4">Choose Locations</option>
						</select>
						<select class="s_select">
							<option value="1">Bathrooms</option>
							<option value="2">Property Type</option>
							<option value="4">Bedrooms</option>
						</select>
					</div>
					<div class="search_range">
						<div class="range_item">
							<h5>Price Range</h5>
							<div id="slider-range"></div>
							<span class="d_text">$200</span>
							<input type="text" id="amount" readonly style="border:0;" class="amount">
						</div>
						<div class="range_item">
							<h5>property Area</h5>
							<div id="slider-range2"></div>
							<span class="d_text2">50sqm</span>
							<input type="text" id="amount2" readonly style="border:0;" class="amount2">
						</div>
					</div>
					<button type="submit" value="submit" class="btn submit_btn">Search Property</button>
				</div>
            </div>
        </section>

        <footer class="footer-area p_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3  col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6 class="footer_title">About Us</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6 class="footer_title">Newsletter</h6>
                            <p>Stay updated with our latest trends</p>		
                            <div id="mc_embed_signup">
                                <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative">
                                    <div class="input-group d-flex flex-row">
                                        <input name="EMAIL" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
                                        <button class="btn sub-btn"><span class="lnr lnr-arrow-right"></span></button>		
                                    </div>									
                                    <div class="mt-10 info"></div>
                                </form>
                            </div>
                        </div>
                    </div>
	
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="single-footer-widget f_social_wd">
                        <h6 class="footer_title">Follow Us</h6>
                        <p>Let us be social</p>
                        <div class="f_social">
                        	<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
                        </div>
                    </div>
                </div>						
                </div>
                <div class="row footer-bottom d-flex justify-content-between align-items-center">
                </div>
            </div>
        </footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>
</html>