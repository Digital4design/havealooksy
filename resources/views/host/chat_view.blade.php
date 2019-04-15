@extends('layouts.hostLayout.hostApp')

@section('pageCss')
<style type="text/css">
    .small-box:hover{color:inherit;}
    .small-box>.inner{padding:5px 8px;}
    .small-box>.inner>p{margin-bottom:0px;}
    .chat-screen{padding: 10px;height:50vh;overflow-y:scroll;display:flex;flex-direction:column;}
    .align-self-end{align-self:flex-end;}
    .align-self-start{align-self:flex-start;}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1 style="display: inline;">{{ $conv_with_user['first_name'] }} {{ $conv_with_user['last_name'] }}</h1>&nbsp;<span style="display: inline;"><small>({{ $conv_with_user['getRole']['display_name'] }})</small></span>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12" style="margin-bottom:15px;">
              <div class="col-xs-12 bg-gray-light chat-screen">
                @if($messages)
                  @foreach($messages as $val)
                    @if($val['user_id'] == Auth::user()->id)
                      <div class="small-box bg-aqua align-self-end" style="margin-bottom:10px;max-width:45%;">
                          <div class="inner">
                              <p>{{ $val['body'] }}</p>
                          </div>
                      </div>
                    @else
                      <div class="small-box bg-yellow align-self-start" style="margin-bottom:10px;max-width:45%;">
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
            <div class="col-lg-12 col-xs-12">
                <form method="POST" action="{{ url('host/chat/send-message') }}">
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
                        <button type="submit" class="btn btn-block btn-danger" style="padding:9px 28px;">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection