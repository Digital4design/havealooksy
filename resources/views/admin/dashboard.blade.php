@extends('layouts.adminLayout.adminApp')

<style type="text/css">
    .bg-orange-light{background-color:#ffdcc2;}
    .text-orange{color:orange;}
</style>

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
                        <div class="d-inline-block">
                            <h5 class="text-muted">Users</h5>
                            <h2 class="mb-0">{{ $users }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                            <i class="fa fa-fw fas fa-sm fa-users text-info"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('admin/users') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <div class="d-inline-block">
                            <h5 class="text-muted">Categories</h5>
                            <h2 class="mb-0">{{ $categories }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
                            <i class="fa fa-fw fas fa-sm fa-list-alt text-secondary"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('admin/categories') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <div class="d-inline-block">
                            <h5 class="text-muted">Listings</h5>
                            <h2 class="mb-0">{{ $listings }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                            <i class="fa fa-fw fas fa-sm fa-shopping-bag text-primary"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('admin/listings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <div class="d-inline-block">
                            <h5 class="text-muted">Bookings</h5>
                            <h2 class="mb-0">{{ $bookings }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg  bg-danger-light mt-1">
                            <i class="fa fa-fw fas fa-sm fa-calendar-alt text-danger"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('admin/bookings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <div class="d-inline-block">
                            <h5 class="text-muted">Orders</h5>
                            <h2 class="mb-0">{{ $orders }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                            <i class="fa fa-fw fas fa-sm fa-shopping-cart text-success"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('admin/orders') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <div class="d-inline-block">
                            <h5 class="text-muted">Invoices</h5>
                            <h2 class="mb-0">{{ $invoices }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg  bg-orange-light mt-1">
                            <i class="fa fa-fw fas fa-sm fa-file-alt text-orange"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('admin/invoices') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <div class="d-inline-block">
                            <h5 class="text-muted">Messages</h5>
                            @php $unreadCount = Chat::messages()->for(Auth::user())->unreadCount(); @endphp
                            <h2 class="mb-0">{{ $unreadCount }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg  bg-brand-light mt-1">
                            <i class="fa fa-fw fas fa-sm fa-comment text-brand"></i>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a href="{{ url('admin/chat') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection