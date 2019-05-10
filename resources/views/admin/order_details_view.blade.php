@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
    .box-row p{margin:0px;}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Order Details</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/orders') }}" class="breadcrumb-link">Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body box">
                @foreach($order_items as $item)
                    <div class="box-row" style="flex-direction:column;border-bottom:1px solid #eee;">
                        <label><a href="{{ url('admin/listings/view/'.$item['id']) }}" class="text-secondary">{{ $item['getBookedListingUser']['title'] }}</a></label>
                        <p>Date: {{ Carbon::create($item['date'])->format('d F, Y') }}</p>
                        <p>No of seats: {{ $item['no_of_seats'] }}</p>
                        <p>Time Slot: {{ Carbon::create($item['getBookedListingTime']['start_time'])->format('g:i a') }}-{{ Carbon::create($item['getBookedListingTime']['end_time'])->format('g:i a') }}</p>
                    </div>
                @endforeach
            </div>
          </div>
        </div> 
    </div>
</div>
@endsection

@section('pageJs')
@stop