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
        <!-- Custom styles for this template -->
        <link href="{{asset('public/looksyassets/css/owl.carousel.css')}}" rel="stylesheet">
        <link href="{{asset('public/looksyassets/css/owl.theme.default.min.css')}}"  rel="stylesheet">
        <link href="{{asset('public/looksyassets/css/style.css')}} " rel="stylesheet">
        
        <script src="{{asset('public/looksyassets/js/ie-emulation-modes-warning.js')}}"></script>
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        <style type="text/css">
            .login.hoverable{background-color:transparent;}
            .login.hoverable a{border-radius:5px;padding:10px 35px;}
            .dropdown-items{position:absolute;list-style:none;background-color:rgba(118,29,201,0.8);right:0px;z-index:1;color:#fff;border-radius:5px;margin-top:5px;padding:0px;display:none;}
            li.dropdown-item{padding:15px 10px;}
            li.dropdown-item:hover{background-color:rgb(118,29,201);width:100%;}
            li.dropdown-item a{text-decoration:none;}
            li.dropdown-item a:hover{background-color:transparent;}
            .show-hide{display:block;}
        </style>
        @yield('pageCss')
    </head>
    <body id="page-top">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
        <div class="top-bar">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll col-lg-3">
                    
                    <a class="navbar-brand page-scroll" href="#page-top"><img src="{{asset('public/looksyassets/images/logo.png') }}
                        " alt="Lattes theme logo"></a>
                </div>

                <!-- Search Form -->
                <form action="#" method="post" novalidate="novalidate" class="col-lg-6">
                    <div class="search_form_container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                                        <input type="text" class="form-control search-slt" placeholder="Industry">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                                        <input type="text" class="form-control search-slt" placeholder="City , State , Country">
                                    </div>                                    
                                    <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                                        <button type="button" class="btn btn-danger wrn-btn"> <i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Login User -->
                <div class="menu float-right col-lg-3">
                   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>   
                    <ul class="nav navbar-right"> 
                      <!-- <li style="position:relative;"><a href="">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</a>
                        <ul style="position:absolute;top:50px;left:-15px;">
                            <li class="dropdown-item"><a href="{{ url('buyer/dashboard') }}">Dashboard</a></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            </li>
                        </ul>
                      </li> --> 
                      <li class="login hoverable"><a>{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</a></li>
                      <ul class="dropdown-items">
                          <li class="dropdown-item"><a href="{{ url('buyer/dashboard') }}">Dashboard</a></li>
                          <li class="dropdown-item"><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                      </ul>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                    </form>                             
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
                            <a class="page-scroll" href="#services">Host</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#portfolio">Saved</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="{{ url('home/messages') }}">Messages</a>
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
        <script type="text/javascript">
            $(".login.hoverable").on("click", function(){
                $(".dropdown-items").toggleClass("show-hide", 2000); 
            });
        </script>
        @yield('pageJs')
    </body>
</html>