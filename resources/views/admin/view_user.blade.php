@extends('layouts.adminLayout.adminApp')

@section('pageCss')
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ $user['first_name'] }}&nbsp;{{ $user['last_name'] }}</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/users') }}" class="breadcrumb-link">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user['first_name'] }}&nbsp;{{ $user['last_name'] }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body box">
                <div class="box-row">
                    <label>First Name</label>
                    <p class="box-row-content">{{ $user['first_name'] }}</p>
                </div>
                <div class="box-row">
                    <label>Last Name</label>
                    <p class="box-row-content">{{ $user['last_name'] }}</p>
                </div>
                <div class="box-row">
                    <label>Role</label>
                    <p class="box-row-content">{{ $user['getRole']['display_name'] }}</p>
                </div>
                <div class="box-row">
                    <label>Username</label>
                    <p class="box-row-content">{{ $user['user_name'] }}</p>
                </div>
                <div class="box-row">
                    <label>Email Address</label>
                    <p class="box-row-content">{{ $user['email'] }}</p>
                </div>
                <div class="box-row">
                    <label>Postal Code</label>
                    <p class="box-row-content">{{ $user['postal_code'] }}</p>
                </div>
                <div class="box-row">
                    <label>Profile Picture</label>
                    <p class="box-row-content" id="image-box">
                        @if($user['profile_picture'])
                        <a href="{{ asset('public/images/profile_pictures/'.$user['profile_picture']) }}" data-lightbox="{{ $user['profile_picture'] }}">
                            <img src="{{ asset('public/images/profile_pictures/'.$user['profile_picture']) }}" style="height:80px;">
                        </a>
                        @else
                        {{ '-' }}
                        @endif
                    </p>
                </div>
            </div>
          </div>
        </div> 
    </div>
</div>
<div class="modal fade" id="image-modal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Images</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", "a.approve-unapprove", function(){
          var id = $(this).attr('data-id');
          var that = this;

          if($(this).hasClass("btn-danger")){
            $(this).removeClass("btn-danger")
            newclass = "btn-default";
            message = "Approved";
            newlabel = "Unapprove";
            approval_data = 1;
          }
          if($(this).hasClass("btn-default")){
            $(this).removeClass("btn-default")
            newclass = "btn-danger";
            message = "Unapproved";
            newlabel = "Approve";
            approval_data = 0;
          }
          $("#loading").toggleClass("hide");
          $.ajax({
            'url'      : '{{ url("admin/listings/change-approval") }}/'+id+"/"+approval_data,
            'method'   : 'get',
            'dataType' : 'json',
            success    : function(data){
              if(data.status == 'success'){
                $(that).addClass(newclass);
                $(that).text(newlabel);
                $("#loading").toggleClass("hide");
                swal({
                    title: "Success",
                    text: "Listing has been "+message+"!",
                    timer: 2000,
                    type: "success",
                    showConfirmButton: false
                });
              }  
            } 
          });
          return false;
        });
    });
</script>
@stop