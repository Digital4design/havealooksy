@extends('layouts.sellerLayout.sellerApp')

@section('pageCss')
<style type="text/css">
.conv-screen{padding: 10px;height:65vh;display:flex;flex-direction:column;overflow-y:scroll;}
/*.profile_pic, */.conv-profile_pic{position:relative;}
/*.profile_pic img{position:absolute;height:35px;width:100%;top:-16px;left:0;}*/
.small-box.user>.inner, .small-box.conv>.inner{display:flex;justify-content:center;align-items:center;padding:10px;text-decoration:none;}
.small-box.user{margin-bottom:10px;border-radius:5px;}
.small-box>.inner:hover{background-color:#9ae5e5;border-radius:5px;color:#fff;}
.conv-profile_pic img{border-radius:50%;position: absolute;top:-30px;left:15px;height: 60px;width: 70%;border:2px solid #ccc;}
.small-box>.inner.no_conversation:hover{background-color:transparent;color:#333;}
.unread{color:orange;position:relative;font-size:22px;}
@media (max-width: 767px){
  .conv_data{text-align:left;}
  .conv-profile_pic img{width:60% !important;}
  .new_conv_pic{width:18% !important;}
  .new_conv_pic img{float:left;}
}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>All Conversations</h1>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-xs-12" style="margin-bottom:12px;">
            <div class="pull-right">
              <button id="new-conversation-button" type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#start-new-conversation"><i class="fa fa-commenting-o"></i>&nbsp;&nbsp;New Conversation</button>
            </div>
          </div>
          <div class="col-lg-12 col-xs-12">
            <div class="col-xs-12 bg-gray-light conv-screen">
              @if(!$conversations->isEmpty())
                @foreach($conversations as $val)
                  <div class="small-box conv" style="margin-bottom:10px;border-radius:5px;box-shadow:1px 1px 5px #ccc;">
                      <a href="{{ url('seller/chat/get-chat/'.$val['user']['id']) }}" class="inner conv_link" style="padding:10px;">
                          <div class="col-lg-1 col-xs-4 conv-profile_pic">
                            <img src="{{ $val['user']['profile_picture'] ? asset('public/images/profile_pictures/'.$val['user']['profile_picture']) : asset('public/images/default-pic.png')}}">
                          </div>
                          <div class="col-lg-11 col-xs-8 conv_data" style="display:flex;flex-direction:column;">
                            <h4>{{ $val['user']['first_name'] }} {{ $val['user']['last_name'] }}<div class="pull-right">
                              @if($val['unread_count'] != 0)
                              <i class="fa fa-circle unread"><span style="font-size:15px;color:#fff;position:absolute;left:2px;top:3px;">&nbsp;{{ $val['unread_count'] }}</span></i>
                              @endif
                            </div></h4>
                            <p style="margin-bottom:0px;color:#999;font-size:12px;">{{ $val['last_message']['body'] }}<span class="pull-right" style="font-size:12px;color:#999;">&nbsp;({{ $val['user']['getRole']['display_name'] }})</span></p>
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
    </section>
</div>
<div class="modal fade" id="start-new-conversation" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content" style="max-height:90vh;overflow-y:scroll;">
      <form id="new_conversation_form" method="POST">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Start New Conversation</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            @foreach($users as $usr)
              <div class="small-box user" style="box-shadow:1px 1px 5px #ccc;">
                  <a href="{{ url('seller/chat/get-chat/'.$usr['id']) }}" class="inner">
                      <div class="col-lg-1 col-xs-3 new_conv_pic" style="position:relative;height:52px;width:9.9%;">
                        <img src="{{ $usr['profile_picture'] ? asset('public/images/profile_pictures/'.$usr['profile_picture']) : asset('public/images/default-pic.png')}}" style="position:absolute;height:100%;width:100%;top:0px;left:0;border-radius:50%;border:2px solid #ccc;">
                      </div>
                      <div class="col-lg-11 col-xs-9 conv_data">
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