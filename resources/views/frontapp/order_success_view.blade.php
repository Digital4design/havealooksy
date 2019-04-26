@extends('layouts.shopperLayout.shopperFrontApp')

@section('pageCss')
    <style type="text/css">
      section{padding-top:20px;}
      .card{margin-top:0px;}
      #order_number{color:#38d038;font-weight:400;}
      .btn-outline-info{background-color:#8241bf;color:#fff;}
    </style>
@stop

@section('content')
<section>
	<div class="container">
		<div class="card text-center">
        @if(Session::has('order_status'))
          <div class="card-header" style="border-bottom: 1px solid #a6eaa6;">
            <h3 style="color:#38d038;font-weight:400;">Order Placed Successfully!</h3>
          </div>
          <div class="card-body">
            <p>Your order has been placed with order number - <span id="order_number">{{ Session::get('order_number') }}</span>.</p>
            <p>Please keep it safe with you. You can use it for further communication with us.</p>
            <a href="{{ url('/') }}" class="btn btn-outline-info btn-sm">Continue Shopping</a>
          </div>
        @else
          <div class="text-center" style="padding-top:70px;">
              <p>Nothing to see here...</p>
              <a href="{{ url('/') }}" class="btn btn-outline-info btn-sm">Continue Shopping</a>
          </div>
        @endif
    </div>
	</div>
</section>
@endsection

@section('pageJs')
@stop