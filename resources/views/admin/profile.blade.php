@extends('layouts.adminLayout.adminApp')
@section('content')
<div class="content-wrapper">
    <section class="content">
      @if(Session::get('status') == "success")
      <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <i class="icon fa fa-check"></i>{{ Session::get('message') }}
      </div>
      @elseif(Session::get('status') == "danger")
      <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <i class="icon fa fa-ban"></i>{{ Session::get('message') }}
      </div>
      @endif
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Profile</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('/admin/edit-profile') }}">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">First Name</label>
                  <div class="col-sm-10">
                    <input id="first_name" name="firstname" type="text" class="form-control" placeholder="First Name" value="{{ $errors->has('firstname') ? old('firstname') : $user_data['first_name'] }}">

                    @if ($errors->has('firstname'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('firstname') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                  <div class="col-sm-10">
                    <input id="last_name" name="lastname" type="text" class="form-control" placeholder="Last Name" value="{{ $errors->has('lastname') ? old('lastname') : $user_data['last_name'] }}">

                    @if ($errors->has('lastname'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('lastname') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="email_address" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input id="email_address" name="email" type="email" class="form-control" placeholder="Email Address" value="{{ $user_data['email'] }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="user_name" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10">
                    <input id="user_name" name="username" type="text" class="form-control" placeholder="Username" value="{{ $errors->has('username') ? old('username') : $user_data['user_name'] }}">

                    @if ($errors->has('username'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('username') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="postal_code" class="col-sm-2 control-label">Postal Code</label>
                  <div class="col-sm-10">
                    <input id="postal_code" name="postalcode" type="text" class="form-control" placeholder="Postal Code" value="{{ $errors->has('postalcode') ? old('postalcode') : $user_data['postal_code'] }}">

                    @if ($errors->has('postalcode'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('postalcode') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection