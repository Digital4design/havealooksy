@extends('layouts.adminLayout.adminApp')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Change Password</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
              <form class="form-horizontal" method="POST" action="{{ url('admin/save-password') }}">
                @csrf
                <div class="box-body">
                  <div class="form-group">
                      <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                      @if ($errors->has('old_password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                      <input type="password" name="new_password" class="form-control" placeholder="New Password">
                      @if ($errors->has('new_password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('new_password') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                      <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                      @if ($errors->has('confirm_password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('confirm_password') }}</strong>
                        </span>
                      @endif
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="float:right;">
                  <button type="submit" class="btn btn-info">Save</button>
                </div>
                <!-- /.box-footer -->
              </form>
            </div>
          </div>
        </div> 
    </div>
</div>
@endsection