@extends('layouts.shopperLayout.shopperFrontApp')

@section('pageCss')
    <style type="text/css">
      section{padding-top:20px;}
      .card{margin-top:0px;}
      .btn-outline-info{background-color:#8241bf;color:#fff;}
      img{height:100%;}
    </style>
@stop

@section('content')
<section>
	<div class="container">
		<div class="card">
      @if(!$wishlist->isEmpty())
        <div class="card-header">
          <h3>Saved Products</h3>
        </div>
        <div class="card-body">
          @foreach($wishlist as $w)
          <a class="wishlist-link" href="{{ url('/get-products/product-details/'.$w['getListing']['id']) }}">
            <div class="wishlist-body">
              <div class="wishlist-image">
                <img src="{{ asset('public/images/listings/'.$w['getListingImages'][0]['name']) }}">
              </div>
              <div class="wishlist-details">
                <h4>{{ $w['getListing']['title'] }}
                  <span class="wishlist-price">Price: ${{ $w['getListing']['price'] }}</span>
                </h4>
                <p>{{ $w['getListing']['location'] }}</p>
                <p>{{ $w['getListing']['description'] }}</p>
              </div>
            </div>
          </a>
          @endforeach
        </div>
      @else
        <div class="text-center" style="padding-top:70px;">
            <p>No saved products.</p>
            <a href="{{ url('/') }}" class="btn btn-outline-info btn-sm">Continue Shopping</a>
        </div>
      @endif
    </div>
	</div>
</section>
@endsection

@section('pageJs')
@stop