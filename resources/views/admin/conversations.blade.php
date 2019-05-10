@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
.conv-screen{padding-right:10px;height:65vh;display:flex;flex-direction:column;}
.small-box.user>.inner, .small-box.conv>.inner{display:flex;justify-content:center;align-items:center;padding:5px;text-decoration:none;}
.small-box.user{margin-bottom:10px;border-radius:5px;}
.small-box>.inner:hover{background-color:#d2d8ff;border-radius:5px;color:#fff;}
.small-box>.inner.no_conversation:hover{background-color:transparent;color:#333;}
.unread{color:#ff5959;position:relative;font-size:18px;}
@media (max-width: 767px){
  .conv_data{text-align:left;}
  .new_conv_pic{width:18% !important;}
  .new_conv_pic img{float:left;}
}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">All Conversations</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Messages</li>
                        </ol>
                        <div class="pull-right mb-2">
                          <button id="new-conversation-button" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#start-new-conversation"><i class="fas fa-fw fa-envelope"></i>&nbsp;&nbsp;New Conversation</button>
                        </div>
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
    <div class="row" style="overflow:hidden;height:400px;width:auto;position:relative;">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card" style="overflow:auto;height:400px;width:100%;position:absolute;">
            <div class="card-body">
                <div class="conv-screen">
                  @if(!$conversations->isEmpty())
                    @foreach($conversations as $val)
                      <div class="small-box conv" style="margin-bottom:10px;border-radius:5px;box-shadow:1px 1px 5px #ccc;">
                          <a href="{{ url('admin/chat/get-chat/'.$val['user']['id']) }}" class="inner conv_link" style="padding:5px;">
                              <div class="col-xl-1 col-lg-1 col-md-1 col-sm-3 col-3">
                                <img class="user-avatar-lg rounded-circle" src="{{ $val['user']['profile_picture'] ? asset('public/images/profile_pictures/'.$val['user']['profile_picture']) : asset('public/images/default-pic.png')}}">
                              </div>
                              <div class="col-xl-11 col-lg-11 col-md-11 col-sm-9 col-9 conv_data" style="display:flex;flex-direction:column;">
                                <h5 style="margin:5px 0px;">{{ $val['user']['first_name'] }} {{ $val['user']['last_name'] }}<div class="pull-right">
                                  @if($val['unread_count'] != 0)
                                  <i class="fa fa-circle unread"><span style="font-size:11px;color:#fff;position:absolute;left:6px;top:4px;">&nbsp;{{ $val['unread_count'] }}</span></i>
                                  @endif
                                </div></h5>
                                <p style="margin-bottom:0px;color:#636363;font-size:12px;">{{ str_limit($val['last_message']['body'], 150) }}<span class="pull-right" style="font-size:12px;color:#999;">&nbsp;({{ $val['user']['getRole']['display_name'] }})</span></p>
                              </div>
                          </a>
                      </div>
                    @endforeach
                  @else
                    <div class="small-box text-center" style="box-shadow:none;">
                        <div class="inner no_conversation">
                            <p>No conversation.</p>
                        </div>
                    </div>
                  @endif
                </div>
            </div>
          </div>
        </div> 
    </div>
</div>
<div class="modal fade" id="start-new-conversation" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content" style="max-height:90vh;overflow:auto;">
      <form id="new_conversation_form" method="POST">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Start New Conversation</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            @foreach($users as $usr)
              <div class="small-box user" style="box-shadow:1px 1px 5px #ccc;">
                  <a href="{{ url('admin/chat/get-chat/'.$usr['id']) }}" class="inner">
                      <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3" style="position:relative;height:52px;width:9.9%;">
                        <img class="user-avatar-lg rounded-circle" src="{{ $usr['profile_picture'] ? asset('public/images/profile_pictures/'.$usr['profile_picture']) : asset('public/images/default-pic.png')}}">
                      </div>
                      <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-9 conv_data">
                        <p style="margin-bottom:0px;">{{ $usr['first_name'] }} {{ $usr['last_name'] }}<span class="pull-right" style="font-size:12px;color:#999;">&nbsp;({{$usr['getRole']['display_name']}})</span></p>
                      </div>
                  </a>
              </div>
            @endforeach
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
@stop