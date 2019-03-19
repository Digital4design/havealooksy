<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/dist/css/skins/_all-skins.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <!-- <link rel="stylesheet" href="{{asset('adminPanelAssets')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{asset('public/css/custom-css.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/sweetalert/sweetalert.min.css')}}">
  <style type="text/css">
    #profile-button:hover, #logout-button:hover{color:#fff;background-color: #d33724;border-color: #f39c12;}
    .navbar-nav>.user-menu>.dropdown-menu>.user-footer{background-color:#357ca5;}
    .user-panel img.img-circle{width:100%;height:auto;max-width:50px;min-height:50px;}
    .user-header img.img-circle{z-index: 5;border: 3px solid;width:90px;height:90px;border-color: rgba(255,255,255,0.2);}
    .change-pic-link{position:relative;}
    #header-pic-link:hover{background-color: transparent;}
    .change-pic-link:hover img.img-circle{opacity:0.7;background-color:rgba(0,0,0,0.7);}
  </style>
  @yield('pageCss')
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="{{ url('/admin') }}" class="logo">
      <span class="logo-mini"><b>A</b>LT</span>
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('public/adminPanelAssets')}}/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('public/adminPanelAssets')}}/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('public/adminPanelAssets')}}/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('public/adminPanelAssets')}}/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('public/adminPanelAssets')}}/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.svg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <a id="header-pic-link" href="#" data-target="#change-picture" data-toggle="modal" class="change-pic-link" style="display:unset;padding:0;">
                  <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.svg') }}" class="img-circle" alt="User Image">
                  <span class="change-pic" style="display:none;font-size:1.2em;position:absolute;top:2px;left:30px;color:#fff;">{{ (Auth::user()->profile_picture) ? 'Edit' : 'Add' }}</span>
                </a>

                <p>
                  {{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}
                  <small>Member since {{ Auth::user()->created_at->format('d/m/Y') }}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('/admin/profile') }}" id="profile-button" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" id="logout-button" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <a href="#" data-target="#change-picture" data-toggle="modal" class="change-pic-link">
            <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.svg') }}" class="img-circle" alt="User Image">
            <span class="change-pic" style="display:none;font-size:0.9em;position:absolute;top:3px;left:15px;">{{ (Auth::user()->profile_picture) ? 'Edit' : 'Add' }}</span>
          </a>
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</p>
          <p>{{ Auth::user()->roles->first()->display_name }}</p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ Request::is('admin') ? 'active' : '' }}">
          <a href="{{ url('/admin') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
          <a href="{{ url('admin/users') }}">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
        <li class="{{ Request::is('admin/categories') ? 'active' : '' }}">
          <a href="{{ url('admin/categories') }}">
            <i class="fa fa-list"></i> <span>Categories</span>
          </a>
        </li>
        <li class="{{ Request::is('admin/change-password') ? 'active' : '' }}">
          <a href="{{ url('admin/change-password') }}">
            <i class="fa fa-unlock"></i> <span>Change Password</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- Modals -->
<div class="modal fade" id="change-picture" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ url('admin/change-profile-picture') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">{{ (Auth::user()->profile_picture) ? 'Edit Profile Picture' : 'Add Profile Picture' }}</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Select Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
            <p class="help-block">Only .jpeg, .jpg, .png are supported.</p>

            @if ($errors->has('profile_picture'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('profile_picture') }}</strong>
              </span>
            @endif
          </div>
          @if(Auth::user()->profile_picture)
          <div class="form-group">
            <img src="{{ asset('public/images/profile_pictures/'.Auth::user()->profile_picture) }}" style="height:auto;width:100%;">
          </div>
          <div class="form-group">
            <a href="{{ url('admin/remove-profile-picture') }}" class="btn btn-block btn-warning" style="margin-top:10px;">Remove Profile Picture</a>
          </div>
          @endif
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modals -->

<!-- jQuery 3 -->
<script src="{{asset('public/adminPanelAssets')}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/adminPanelAssets')}}/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/adminPanelAssets')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('public/adminPanelAssets')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- DataTables -->
<script src="{{asset('public/adminPanelAssets')}}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('public/adminPanelAssets')}}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/adminPanelAssets')}}/dist/js/adminlte.min.js"></script>
<script src="{{asset('public/js/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript">
  $(".change-pic-link").mouseover(function(){
    $(".change-pic").css("display", "block");
  });
  $(".change-pic-link").mouseout(function(){
    $(".change-pic").css("display", "none");
  }); 
</script>
@yield('pageJs')
</body>
</html>

