<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('public/dashboardAssets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">
    <!-- TimePicker -->
    <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/datatables/css/buttons.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/datatables/css/select.bootstrap4.css') }}">
    <!-- LightBox -->
    <link rel="stylesheet" href="{{asset('public/css/lightbox')}}/lightbox.min.css">
    <!-- Full Calendar -->
    <link rel="stylesheet" href="{{ asset('public/dashboardAssets/vendor/full-calendar/css/fullcalendar.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('public/css/custom-css.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/sweetalert/sweetalert.min.css')}}">
    <title>Looksy</title>
    <style type="text/css">
    </style>
    @yield('pageCss')
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="{{ url('/') }}">Looksy</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <!-- <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icons" href="#" id="get_unread_conversations" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-envelope my-2"></i>
                              @php $unreadCount = Chat::messages()->for(Auth::user())->unreadCount(); @endphp
                                @if($unreadCount) 
                                  <span class="indicator" style="right:20px;"></span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                  <div class="notification-title">You have {{ $unreadCount }} unread messages</div>
                                  <div id="conversations_list">
                                  </div>
                                </li>
                                <li>
                                    <div class="list-footer" style="font-weight:normal;"> <a href="{{ url('admin/chat') }}">View all messages</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  onclick="markNotificationsAsRead()"><i class="fas fa-fw fa-bell my-2"></i>
                              @if(count(Auth::user()->unreadNotifications))
                                <span class="indicator nav-unread"></span>
                              @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title">You have {{ (count(Auth::user()->unreadNotifications)) ? count(Auth::user()->unreadNotifications) : 0 }} notifications</div>
                                    @if(!Auth::user()->unreadNotifications->isEmpty())
                                    <div class="notification-list">
                                        <div class="list-group">
                                          @foreach(Auth::user()->unreadNotifications as $notification)
                                            <a href="{{ $notification->data['action'] }}" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">{{ $notification->data['user'] }}{{ $notification->data['message'] }}
                                                    </div>
                                                </div>
                                            </a>
                                          @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </li>
                                <li>
                                    <div class="list-footer" style="font-weight:normal;"> <a href="{{ url('admin/all-notifications') }}">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.png') }}" alt="User" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</h5>
                                    <small>Member since {{ Auth::user()->created_at->format('d F, Y') }}</small>
                                </div>
                                <a class="dropdown-item" href="{{ url('/admin/profile') }}"><i class="fas fa-user mr-2"></i>Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ url('/admin') }}"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}" href="{{ url('admin/users') }}"><i class="fa fa-fw fa-users"></i>Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/categories') ? 'active' : '' }}" href="{{ url('admin/categories') }}"><i class="fa fa-fw fa-list"></i>Categories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/listings') ? 'active' : '' }}" href="{{ url('admin/listings') }}"><i class="fa fa-fw fa-shopping-bag"></i>Listings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/bookings') ? 'active' : '' }}" href="{{ url('admin/bookings') }}"><i class="fa fa-fw fa-calendar-alt"></i>Bookings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/orders') ? 'active' : '' }}" href="{{ url('admin/orders') }}"><i class="fa fa-fw fa-shopping-cart"></i>Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/invoices') ? 'active' : '' }}" href="{{ url('admin/invoices') }}"><i class="fa fa-fw far fa-file-alt"></i>Invoices</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/ratings') ? 'active' : '' }}" href="{{ url('admin/ratings') }}"><i class="fa fa-fw fa-star"></i>Rating & Reviews</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('admin/chat') ? 'active' : '' }}" href="{{ url('admin/chat') }}"><i class="fab fa-fw fas fa-comments"></i>Messages
                                  @if($unreadCount != 0)
                                    <span class="badge badge-success" style="display:inline-block">{{ $unreadCount }}</span>
                                  @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/change-password') ? 'active' : '' }}" href="{{ url('admin/change-password') }}"><i class="fas fa-fw fa-unlock"></i>Change Password</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper" style="height:100%;min-height:596px !important;">
            <div class="dashboard-ecommerce">
              @yield('content')
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer" style="position:absolute;bottom:0;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                             Copyright © 2019 Looksy. All rights reserved.
                        </div>
                        <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <div id="loading" class="hide" style="position:absolute;top:50%;left:50%;z-index:1111;">
      <div class="loader"></div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="{{ asset('public/dashboardAssets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstap bundle js -->
    <script src="{{ asset('public/dashboardAssets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- slimscroll js -->
    <script src="{{ asset('public/dashboardAssets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('public/dashboardAssets/libs/js/main-js.js') }}"></script>
    <!-- sparkline js -->
    <script src="{{ asset('public/dashboardAssets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <!-- TimePicker -->
    <script src="{{asset('public/adminPanelAssets')}}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- DataTables -->
    <script src="{{asset('public/adminPanelAssets')}}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/dashboardAssets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('public/js/datatables')}}/dataTables.buttons.min.js"></script>
    <script src="{{asset('public/js/datatables')}}/buttons.colVis.min.js"></script>
    <script src="{{ asset('public/dashboardAssets/vendor/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/dashboardAssets/vendor/datatables/js/data-table.js') }}"></script>
    <!-- LightBox -->
    <script src="{{asset('public/js/lightbox')}}/lightbox.min.js"></script>
    <!-- Full Calendar -->
    <script src="{{ asset('public/dashboardAssets/vendor/full-calendar/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dashboardAssets/vendor/full-calendar/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dashboardAssets/vendor/full-calendar/js/calendar.js') }}"></script>
    <script src="{{ asset('public/dashboardAssets/vendor/full-calendar/js/fullcalendar.js') }}"></script>
    <!-- SweetAlert -->
    <script src="{{asset('public/js/sweetalert/sweetalert.min.js')}}"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.timepicker').timepicker({
            showInputs: false, /*showMeridian:false,*/ defaultTime: ''
        });
        $(document).on("click", "#get_unread_conversations", function(){
          $.ajax({
            'url'      : '{{ url("admin/get-unread-conversations") }}',
            'method'   : 'get',
            'dataType' : 'json',
            success    : function(resp){
              
                if(resp.status == 'success'){
                  if(resp.conversations !=""){
                    $("#conversations_list").append(resp.conversations);
                  }
                }
            } 
          });
        });
      });

      function markNotificationsAsRead()
      {
        $("span.nav-unread").remove();
        $.get('{{ url("admin/markAsRead") }}');
      }
    </script>
    @yield('pageJs')
</body>
 
</html>