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
                    <h3 class="box-title">Change Password</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" method="POST" action="{{ url('/admin/save-password') }}">
                    @csrf
                    <div class="box-body">
                      <div class="form-group">
                        <label for="old_password" class="col-sm-2 control-label">Old Password</label>
                        <div class="col-sm-10">
                          <input id="old_password" type="password" name="old_password" class="form-control" placeholder="Old Password">
                          @if ($errors->has('old_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="new_password" class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-10">
                          <input id="new_password" type="password" name="new_password" class="form-control" placeholder="New Password">
                          @if ($errors->has('new_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('new_password') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">
                          <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                          @if ($errors->has('confirm_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('confirm_password') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info pull-right">Save</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection