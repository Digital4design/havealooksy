@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
    .small-box{border-radius:5px;}
    .small-box>.inner{padding:5px 8px;color:#fff;}
    .small-box>.inner>p{margin-bottom:0px;}
    .chat-screen{padding:10px;height:50vh;display:flex;flex-direction:column;}
    .align-self-end{align-self:flex-end;}
    .align-self-start{align-self:flex-start;}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
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
        <h2>{{ $conv_with_user['first_name'] }} {{ $conv_with_user['last_name'] }}<span><small>({{ $conv_with_user['getRole']['display_name'] }})</small></span></h2>
      </div>
    </div>
    <div class="row" style="overflow:hidden;height:500px;width:auto;position:relative;">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card" style="overflow:auto;height:500px;width:100%;position:absolute;">
            <div class="card-body" style="padding:5px 10px 5px 5px;">
              <div class="chat-screen" style="overflow:auto;">
              @if($messages)
                  @foreach($messages as $val)
                    @if($val['user_id'] == Auth::user()->id)
                      <div class="small-box bg-info align-self-end" style="margin-bottom:10px;max-width:45%;">
                          <div class="inner">
                              <p>{{ $val['body'] }}</p>
                          </div>
                      </div>
                    @else
                      <div class="small-box bg-warning align-self-start" style="margin-bottom:10px;max-width:45%;">
                          <div class="inner">
                              <p>{{ $val['body'] }}</p>
                          </div>
                      </div>
                    @endif
                  @endforeach
                @else
                  <div class="small-box text-center" style="box-shadow:none;">
                      <div class="inner">
                          <p>No message.</p>
                      </div>
                  </div>
                @endif
              </div>
            </div>
            <div class="card-footer">
              <form method="POST" action="{{ url('admin/chat/send-message') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $conv_with_user['id'] }}">
                <div class="form-group">
                    <textarea rows="3" class="form-control" name="message" placeholder="Write message here..."></textarea>
                    @if ($errors->has('message'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('message') }}</strong>
                      </span>
                    @endif
                </div>
                <div class="form-group pull-right" style="margin-bottom:0px;">
                    <button type="submit" class="btn btn-block btn-primary" style="padding:9px 28px;">Send</button>
                </div>
              </form>
            </div>
          </div>
        </div> 
    </div>
</div>
@endsection