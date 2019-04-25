@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  a.notification-box{color:inherit;text-decoration:none;width:100%;}
  a.notification-box:hover .box-row{background-color:#ceffff;}
  .box .box-row{padding:10px;border-bottom: 1px solid #ceffff;}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
              <div class="box box-info" style="height:500px;overflow-y:scroll;">
                <div class="box-header">
                  <h3 class="box-title">All Notifications</h3>
                </div>
                <div class="box-body">
                  @if(!Auth::user()->notifications->isEmpty())
                    @foreach(Auth::user()->notifications as $notification)
                      <a href="{{ url($notification->data['action']) }}" class="notification-box">
                        <div class="box-row">
                          <div>
                            {{ $notification->data['user'] }}{{ $notification->data['message'] }}
                          </div>
                        </div>
                      </a>
                      @endforeach
                  @else
                    <p class="">No notification.</p>
                  @endif
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('pageJs')
@stop