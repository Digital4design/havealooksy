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
  <!-- TimePicker -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('public/adminPanelAssets')}}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('public/css/datatables')}}/buttons.dataTables.min.css">
  <!-- LightBox -->
  <link rel="stylesheet" href="{{asset('public/css/lightbox')}}/lightbox.min.css">
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
    .error{color:red;}
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
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="conversations_list">
                </ul>
              </li>
              <li class="footer"><a href="{{ url('admin/chat') }}">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="markNotificationsAsRead()">
              <i class="fa fa-bell-o"></i>
              @if(count(Auth::user()->unreadNotifications))
                <span class="label label-warning nav-unread">{{count(Auth::user()->unreadNotifications)}}</span>
              @endif
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ (count(Auth::user()->unreadNotifications)) ? count(Auth::user()->unreadNotifications) : 0 }} notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @if(!Auth::user()->unreadNotifications->isEmpty())
                    @foreach(Auth::user()->unreadNotifications as $notification)
                      <li>
                        <a class="notification_link" href="{{ $notification->data['action'] }}">
                          <div>
                            <p>{{ $notification->data['user'] }}{{ $notification->data['message'] }}</p>
                          </div>
                        </a>
                      </li>
                    @endforeach
                  @else
                    <p class="text-center">No new notification.</p>
                  @endif
                </ul>
              </li>
              <li class="footer"><a id="view_all_notifications" href="{{ url('admin/all-notifications') }}">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <a id="header-pic-link" href="#" data-target="#change-picture" data-toggle="modal" class="change-pic-link" style="display:unset;padding:0;">
                  <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.png') }}" class="img-circle" alt="User Image">
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
        <div class="pull-left image" style="padding:0px;">
          <a href="#" data-target="#change-picture" data-toggle="modal" class="change-pic-link">
            <img src="{{ (Auth::user()->profile_picture) ? asset('public/images/profile_pictures/'.Auth::user()->profile_picture) : asset('public/images/default-pic.png') }}" class="img-circle" alt="User Image" style="transition: min-height 0.1s ease-in-out;">
            <span class="change-pic" style="display:none;font-size:0.9em;position:absolute;top:3px;left:15px;">{{ (Auth::user()->profile_picture) ? 'Edit' : 'Add' }}</span>
          </a>
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
        <li class="{{ Request::is('admin/listings') ? 'active' : '' }}">
          <a href="{{ url('admin/listings') }}">
            <i class="fa fa-list-alt"></i> <span>Listings</span>
          </a>
        </li>
        <li class="{{ Request::is('admin/bookings') ? 'active' : '' }}">
          <a href="{{ url('admin/bookings') }}">
            <i class="fa fa-calendar"></i> <span>Bookings</span>
          </a>
        </li>
        <li class="{{ Request::is('admin/orders') ? 'active' : '' }}">
          <a href="{{ url('admin/orders') }}">
            <i class="fa fa-shopping-cart"></i> <span>Orders</span>
          </a>
        </li>
        <li class="{{ Request::is('admin/chat') ? 'active' : '' }}">
          <a href="{{ url('admin/chat') }}">
            <i class="fa fa-commenting"></i> <span>Messages</span><span class="pull-right" style="margin-right:5px;">{{ ($unreadCount != 0) ? $unreadCount : '' }}</span>
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
    <div class="modal-content" style="max-height:90vh;overflow-y:scroll;">
      <form id="profile_picture_form" method="POST" enctype="multipart/form-data">
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
            <a id="remove-profile-picture" href="{{ url('admin/remove-profile-picture') }}" class="btn btn-block btn-warning" style="margin-top:10px;">Remove Profile Picture</a>
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
<!-- TimePicker -->
<script src="{{asset('public/adminPanelAssets')}}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- DataTables -->
<script src="{{asset('public/adminPanelAssets')}}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('public/adminPanelAssets')}}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{asset('public/js/datatables')}}/dataTables.buttons.min.js"></script>
<script src="{{asset('public/js/datatables')}}/buttons.colVis.min.js"></script>
<!-- LightBox -->
<script src="{{asset('public/js/lightbox')}}/lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/adminPanelAssets')}}/dist/js/adminlte.min.js"></script>
<script src="{{asset('public/js/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(".change-pic-link").mouseover(function(){
    $(".change-pic").css("display", "block");
  });
  $(".change-pic-link").mouseout(function(){
    $(".change-pic").css("display", "none");
  });
  $('.timepicker').timepicker({
      showInputs: false, /*showMeridian:false,*/ defaultTime: ''
    });
  $("a.sidebar-toggle").on("click", function(){
      // $(".user-panel img").toggleClass("fix-height");

      if($(".user-panel img").hasClass("fix-height")){
        $(".user-panel img").removeClass("fix-height");
        $(".user-panel img").animate({minHeight: "50px"}, 0, 'easeInOutQuad');
      }
      else{
        $(".user-panel img").addClass("fix-height");
        $(".user-panel img").animate({minHeight: "30px"}, 300, 'easeInOutQuart');
      }
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
  $("#profile_picture_form").submit(function(){
    var formData = new FormData(this);
    $("#loading").toggleClass("hide");
    $.ajax({
      'url'        : '{{ url("admin/change-profile-picture") }}',
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
      'url'        : '{{ url("admin/remove-profile-picture") }}',
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
            $("img").attr("src", "{{ url('public/images/default-pic.png') }}")
          }
          else if(resp.status == 'danger'){
            swal("Error", resp.message, "warning");
          }
      } 
    });
    return false;
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

