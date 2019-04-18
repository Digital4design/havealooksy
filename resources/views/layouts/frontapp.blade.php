<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ asset('public/favicon.ico') }}">
        <title>Looksy</title>
        <!-- Bootstrap core CSS -->
        <link href="{{asset('public/looksyassets/css/bootstrap.min.css')}} " rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- fullCalendar -->
        <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
        <!-- Custom styles for this template -->
        <link href="{{asset('public/looksyassets/css/owl.carousel.css')}}" rel="stylesheet">
        <link href="{{asset('public/looksyassets/css/owl.theme.default.min.css')}}"  rel="stylesheet">
        <link href="{{asset('public/looksyassets/css/style.css')}} " rel="stylesheet">
        <link href="{{asset('public/css/custom-css.css')}} " rel="stylesheet">
        
        <script src="{{asset('public/looksyassets/js/ie-emulation-modes-warning.js')}}"></script>
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        @yield('pageCss')
    </head>
    <body id="page-top">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
        <div class="top-bar">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll col-lg-3">
                    
                    <a class="navbar-brand page-scroll" href="{{ url('/') }}"><img src="{{asset('public/looksyassets/images/logo.png') }}
                        " alt="Lattes theme logo"></a>
                </div>

                <!-- Search Form -->
                <div class="col-sm-5">
                    <div class="search_form_container">
                        <form action="{{ url('/search') }}" method="post" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 col-xs-4 search_form_input">
                                    <input type="text" name="industry" class="form-control search-slt" placeholder="Industry">
                                </div>
                                <div class="col-sm-4 col-xs-4 search_form_input">
                                    <input type="text" name="location" class="form-control search-slt" placeholder="City , State , Country">
                                </div>                                    
                                <div class="col-sm-4 col-xs-4 search_form_input">
                                    <button type="submit" class="btn btn-danger wrn-btn"> <i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- login signupbtns -->
                <div class="menu float-right col-lg-4">
                   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <ul class="nav navbar-right"> 
                      <li class="cart"><a href="{{ url('/cart') }}"><span class="glyphicon glyphicon-shopping-cart"><span class="label" style="position:absolute;background-color:rgba(137,43,225,0.6);border-radius:50%;font-weight:normal;top:-10px;left:16px;">0</span></span></a></li>
                      <li class="login"><a href="{{ url('/login') }}"> Login</a></li>
                      <li class="signup"><a href="{{ url('/register') }}"> Signup</a></li>           
                    </ul>               
                </div>
                
              </div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="main-menu">
                   <div class="container">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#about">About</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="{{ url('/register') }}">Host</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#portfolio">Saved</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="{{ url('/messages') }}">Messages</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#contact">Contact</a>
                        </li>
                    </ul>
                    </div>
                  </div> 

                </div>
                
                <!-- /.navbar-collapse -->
            <!-- /.container-fluid -->
        </nav>
        <!-- Header -->
        <header>
            
            <div class="slider-container">
                <div class="container">
                    <div class="intro-text">                        
                        <div class="intro-heading">LEARN FROM EXPERIENCE</div>
                        <div class="intro-lead-in">Use looksy to book learning experiences with seasoned professionals</div>
                    </div>
                </div>
            </div>
        </header>
        @yield('content')
        <p id="back-top">
        	<a href="#top"><i class="fa fa-angle-up"></i></a>
        </p>
        <footer>
            <div class="container text-left">
                <p>© All rights reserved2019. Looksy.</p>
            </div>
        </footer>
        <!-- Bootstrap core JavaScript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="{{  asset('public/looksyassets/js/bootstrap.min.js') }}"></script>
        <script src="{{  asset('public/looksyassets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('public/looksyassets/js/cbpAnimatedHeader.js') }}"></script>
        <script src="{{ asset('public/looksyassets/js/theme-scripts.js') }}"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{ asset('public/looksyassets/js/ie10-viewport-bug-workaround.js') }}"></script>
        <!-- fullCalendar -->
        <script src="{{asset('public/adminPanelAssets')}}/bower_components/moment/moment.js"></script>
        <script src="{{asset('public/adminPanelAssets')}}/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        @yield('pageJs')
    </body>
</html>