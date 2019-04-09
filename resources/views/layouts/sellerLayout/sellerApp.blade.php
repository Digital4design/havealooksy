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
    #see_all_messages:hover{color:#000;background-color:silver;}.error{color:red;}
    a.change-picture{letter-spacing:0.5px;font-size:0.75em;padding:5px;}
    a.change-picture:hover{text-decoration:underline;color:rgba(137,43,225,1);}
    a.change-picture-link{visibility:hidden;letter-spacing:0.5px;font-size:1em;color:#fff !important;position:absolute;top:40px;left:95px;padding:35px 20px;}
    a.change-picture-link:hover{color:rgba(0,0,0,0.8);}
    .loader {
      border: 8px solid #f3f3f3;
      border-radius: 50%;
      border-top: 8px solid #3498db;
      width: 50px;
      height: 50px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }
    .hide{display:none;}

    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
  @yield('pageCss')
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="{{ url('/admin') }}" class="logo">
      <!-- <span class="logo-mini"><b>A</b>LT</span> -->
      <span class="logo-lg"><b>LOOKSY</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="get_unread_conversations">
              <i class="fa fa-envelope-o"></i>
              @php $unreadCount = Chat::messages()->for(Auth::user())->unreadCount(); @endphp
              @if($unreadCount)
                <span class="label label-success">{{ $unreadCount }}</span>
              @endif
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ $unreadCount }} unread messages</li>
              <li>
                <ul class="menu" id="conversations_list">
                </ul>
              </li>
              <li class="footer"><a id="see_all_messages" href="{{ url('seller/chat') }}">See All Messages</a></li>
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
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.svg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header" style="position:relative;">
                <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.svg') }}" class="img-circle" alt="User Image">
                <div class="change-picture-div" style="position:absolute;padding:45px;top:10px;left:95px;"></div>
                <a class="change-picture-link" href="#" data-target="#change-picture" data-toggle="modal">Change</a>
                <p>
                  {{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}
                  <small>Member since {{ Auth::user()->created_at->format('d/m/Y') }}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('/seller/profile') }}" id="profile-button" class="btn btn-default btn-flat">Profile</a>
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
            <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.svg') }}" class="img-circle" alt="User Image" style="margin-bottom:5px;">
            <div style="display:block;">
              <a class="change-picture" href="#" data-target="#change-picture" data-toggle="modal">Change</a>
            </div>
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</p>
          <p>{{ Auth::user()->roles->first()->display_name }}</p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ Request::is('seller') ? 'active' : '' }}">
          <a href="{{ url('seller') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="{{ Request::is('seller/listings') ? 'active' : '' }}">
          <a href="{{ url('seller/listings') }}">
            <i class="fa fa-list-alt"></i> <span>Listings</span>
          </a>
        </li>
		    <li class="{{ Request::is('seller/chat') ? 'active' : '' }}">
          <a href="{{ url('seller/chat') }}">
            <i class="fa fa-commenting"></i> <span>Messages</span><span class="pull-right" style="margin-right:5px;">{{ ($unreadCount != 0) ? $unreadCount : '' }}</span>
          </a>
        </li>
        <li class="{{ Request::is('seller/change-password') ? 'active' : '' }}">
          <a href="{{ url('seller/change-password') }}">
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
      <form method="POST" id="profile_picture_form" enctype="multipart/form-data">
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
            <p class="error" id="error-profile_picture"></p>
          </div>
          @if(Auth::user()->profile_picture)
          <div class="form-group" id="uploaded_profile_pic">
            <img src="{{ asset('public/images/profile_pictures/'.Auth::user()->profile_picture) }}" style="height:auto;width:100%;">
          </div>
          <div class="form-group" id="remove_profile_pic_button">
            <a id="remove-profile-picture" href="{{ url('seller/remove-profile-picture') }}" class="btn btn-block btn-warning" style="margin-top:10px;">Remove Profile Picture</a>
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
<div id="loading" class="hide" style="position:absolute;top:50%;left:50%;z-index:1111;">
  <div class="loader"></div>
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
  $(document).ready(function(){
    $("div.change-picture-div").mouseover(function(){
      $("a.change-picture-link").css("visibility", "visible");
    });
    $("div.change-picture-div").mouseout(function(){
      $("a.change-picture-link").css("visibility", "hidden");
    });
    $(document).on("click", "#get_unread_conversations", function(){
      $.ajax({
        'url'      : '{{ url("seller/get-unread-conversations") }}',
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

    $("#profile_picture_form").submit(function(){
      var formData = new FormData(this);
      $("#loading").toggleClass("hide");
      $.ajax({
        'url'        : '{{ url("seller/change-profile-picture") }}',
        'method'     : 'post',
        'dataType'   : 'json',
        'data'       : formData,
        'cache'      : false,
        'contentType': false,
        'processData': false,
        success    : function(resp){
          
            if(resp.status == 'success'){
              $("#loading").toggleClass("hide");
              $("#change-picture").modal("toggle");
              swal({
                title: "Success",
                text: resp.message,
                timer: 2000,
                type: "success",
                showConfirmButton: false
              });
              setTimeout(function(){ 
                  location.reload();
              }, 1000);
            }
            else if(resp.status == 'danger'){
              swal("Error", resp.message, "warning");
            }
            else{
              console.log(resp);

              $('.error').html('');
              $('.error').parent().removeClass('has-error');
              $.each(resp,function(key,value){
                if(value != ""){
                  $("#error-"+key).text(value);
                  $("#error-"+key).parent().addClass('has-error');
                  $("#error-"+key).parent().find('.help-block').css('color', '#737373');
                }
              });
            }
        } 
      });
      return false;
    });

    $("#remove-profile-picture").on("click", function(){
      $("#loading").toggleClass("hide");
      $.ajax({
        'url'        : '{{ url("seller/remove-profile-picture") }}',
        'method'     : 'get',
        'dataType'   : 'json',
        success    : function(resp){
          
            if(resp.status == 'success'){
              $("#loading").toggleClass("hide");
              swal({
                title: "Success",
                text: resp.message,
                timer: 1000,
                type: "success",
                showConfirmButton: false
              });
              $("#uploaded_profile_pic").css("display", "none");
              $("#remove_profile_pic_button").css("display", "none");
              $("img").attr("src", "{{ url('public/images/default-pic.svg') }}")
            }
            else if(resp.status == 'danger'){
              swal("Error", resp.message, "warning");
            }
        } 
      });
      return false;
    });
  }); 
</script>
@yield('pageJs')
</body>
</html>

