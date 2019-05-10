@extends('layouts.adminLayout.adminApp')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Edit Profile</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @if(Session::get('status') == "success")
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ Session::get('message') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </a>
    </div>
    @elseif(Session::get('status') == "danger")
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ Session::get('message') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </a>
    </div>
    @endif
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" method="POST" action="{{ url('/admin/edit-profile') }}" enctype="multipart/form-data">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label for="first_name" class="control-label">First Name</label>
                    <input id="first_name" name="firstname" type="text" class="form-control" placeholder="First Name" value="{{ $errors->has('firstname') ? old('firstname') : $user_data['first_name'] }}">

                    @if ($errors->has('firstname'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('firstname') }}</strong>
                      </span>
                    @endif
                </div>
                <div class="form-group">
                  <label for="last_name" class="control-label">Last Name</label>
                    <input id="last_name" name="lastname" type="text" class="form-control" placeholder="Last Name" value="{{ $errors->has('lastname') ? old('lastname') : $user_data['last_name'] }}">

                    @if ($errors->has('lastname'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('lastname') }}</strong>
                      </span>
                    @endif
                </div>
                <div class="form-group">
                  <label for="email_address" class="control-label">Email</label>
                    <input id="email_address" name="email" type="email" class="form-control" placeholder="Email Address" value="{{ $user_data['email'] }}" disabled>
                </div>
                <div class="form-group">
                  <label for="user_name" class="control-label">Username</label>
                    <input id="user_name" name="username" type="text" class="form-control" placeholder="Username" value="{{ $errors->has('username') ? old('username') : $user_data['user_name'] }}">

                    @if ($errors->has('username'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('username') }}</strong>
                      </span>
                    @endif
                </div>
                <div class="form-group">
                  <label for="postal_code" class="control-label">Postal Code</label>
                    <input id="postal_code" name="postalcode" type="text" class="form-control" placeholder="Postal Code" value="{{ $errors->has('postalcode') ? old('postalcode') : $user_data['postal_code'] }}">

                    @if ($errors->has('postalcode'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('postalcode') }}</strong>
                      </span>
                    @endif
                </div>
                @if(isset($user_data['profile_picture']))
                <div class="form-group">
                  <label for="image" class="control-label">Uploaded Profile Picture</label>
                    <div id="image-box">
                      <a href="{{ asset('public/images/profile_pictures/'.$user_data['profile_picture']) }}" data-lightbox="{{ $user_data['id'] }}">
                          <img src="{{ asset('public/images/profile_pictures/'.$user_data['profile_picture']) }}">
                      </a>
                    </div>
                    <a href="{{ url('admin/remove-profile-picture') }}" class="btn btn-dark btn-sm text-center px-5 mt-3">Remove</a>
                </div>
                @else
                <div class="form-group">
                  <label for="image" class="control-label">Upload Profile Picture</label>
                    <input id="image" name="profile_picture" type="file" class="form-control">
                    <p class="help-block">Only .jpeg, .jpg, .png are supported.</p>

                    @if ($errors->has('profile_picture'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('profile_picture') }}</strong>
                      </span>
                    @endif
                </div>
                @endif
              </div>
              <!-- /.box-body -->
              <div class="box-footer" style="float:right;">
                <button type="submit" class="btn btn-primary pull-right">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
            </div>
          </div>
        </div> 
    </div>
</div>
@endsection