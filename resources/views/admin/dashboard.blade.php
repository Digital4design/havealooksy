@extends('layouts.adminLayout.adminApp')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
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
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $users }}</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{ url('admin/users') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $categories }}</h3>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-filing"></i>
                    </div>
                    <a href="{{ url('admin/categories') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $listings }}</h3>
                        <p>Listings</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ url('admin/listings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $bookings }}</h3>
                        <p>Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="glyphicon glyphicon-calendar" style="font-size:80px;top:5px;"></i>
                    </div>
                    <a href="{{ url('admin/bookings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $orders }}</h3>
                        <p>Orders</p>
                    </div>
                    <div class="icon">
                        <i class="glyphicon glyphicon-shopping-cart" style="font-size:80px;top:5px;"></i>
                    </div>
                    <a href="{{ url('admin/orders') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        @php $unreadCount = Chat::messages()->for(Auth::user())->unreadCount(); @endphp
                        <h3>{{ $unreadCount }}</h3>
                        <p>Messages</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-chatboxes"></i>
                    </div>
                    <a href="{{ url('admin/chat') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section>
</div>
 @endsection