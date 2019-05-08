@extends('layouts.shopperLayout.shopperApp')
@section('content')
<div class="container-fluid dashboard-content ">
    <!-- ============================================================== -->
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Dashboard</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->
    <div class="ecommerce-widget">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <h5 class="text-muted">Bookings</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1">{{ $bookings }}</h1>
                        </div>
                        <div class="d-inline-block float-right text-success font-weight-bold">
                            <i class="fa fa-fw fas fa-shopping-bag dashboard-icon"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('shopper/bookings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <h5 class="text-muted">Rate Your Experience</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1">{{ $ratings }}</h1>
                        </div>
                        <div class="d-inline-block float-right text-success font-weight-bold">
                            <i class="fa fa-fw fa-star dashboard-icon"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('shopper/ratings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <h5 class="text-muted">Messages</h5>
                        <div class="metric-value d-inline-block">
                            @php $unreadCount = Chat::messages()->for(Auth::user())->unreadCount(); @endphp
                            <h1 class="mb-1">{{ $unreadCount }}</h1>
                        </div>
                        <div class="d-inline-block float-right text-success font-weight-bold">
                            <i class="fa fa-fw fas fa-comment dashboard-icon"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('shopper/chat') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection