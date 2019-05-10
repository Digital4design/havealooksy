@extends('layouts.adminLayout.adminApp')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">All Notifications</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin') }}" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="overflow:hidden;height:400px;width:auto;position:relative;">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card p-4" style="overflow:auto;height:400px;width:100%;position:absolute;">
            @if(!Auth::user()->notifications->isEmpty())
              @foreach(Auth::user()->notifications as $notification)
                <a href="{{ url($notification->data['action']) }}" class="notification-box border-bottom py-2">
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
@endsection