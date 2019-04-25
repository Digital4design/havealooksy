@extends('layouts.shopperLayout.shopperFrontApp')

@section('pageCss')
    <style type="text/css">
        h3{margin: 10px auto;}
        .btn-default{border:1px solid rgb(109, 27, 185);}
        .card-body{display:flex;align-items:center;justify-content:center;}
        .form-group{margin-bottom:30px;}
    </style>
@stop

@section('content')
<section class="product-detail">
	<div class="container">
		<div class="card">
            <div class="card-header bg-dark text-light" style="font-weight:300;margin-bottom:0px;">
                <h3>Proceed with Payment<span style="float:right;">Total Amount: ${{ $total }}</span></h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('stripe_payment') }}" style="width:50%;padding:20px;border: 1px solid rgba(0,0,0,0.1);margin-top:20px;">
                @csrf
                <input type="hidden" name="amount" value="{{ $total }}">
                @foreach($bookings_done as $b)
                    <input type="hidden" name="bookings_done[]" value="{{ $b }}">
                @endforeach
                <div class="form-group">
                  <div class='col-lg-12 form-group card required' style="margin-top:10px;">
                    <label class='control-label'>Credit Card Number</label>
                    <input autocomplete='off' class='form-control card-number' placeholder="XXXXXXXXXXXXXXXX" size='20' type='text' name="card_no">
                    @if ($errors->has('card_no'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('card_no') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <div class='col-lg-4 form-group cvc required'>
                    <label class='control-label'>CVV</label>
                    <input autocomplete='off' class='form-control card-cvc' placeholder='XXX' size='4' type='text' name="cvvNumber">
                    @if ($errors->has('cvvNumber'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('cvvNumber') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class='col-lg-4 form-group expiration required'>
                    <label class='control-label'>Expiry Month</label>
                    <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' name="ccExpiryMonth">
                    @if ($errors->has('ccExpiryMonth'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('ccExpiryMonth') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class='col-lg-4 form-group expiration required'>
                    <label class='control-label'>Expiry Year</label>
                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
                    @if ($errors->has('ccExpiryYear'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('ccExpiryYear') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <div class='col-lg-12 form-group'>
                    <button class='form-control btn btn-default submit-button' type='submit'>Pay<span id="total_amount"> ${{ $total }}</span></button>
                  </div>
                </div>
                @if(Session::has('pay-error'))
                <div class="form-group" style="padding-left: 0rem;">
                  <div class='col-lg-12 error form-group'>
                    <div class='alert-danger alert'>
                      {{ Session::get('pay-error') }}
                    </div>
                  </div>
                </div>
                {{ Session::forget('pay-error') }}
                @endif
                @if(Session::has('success'))
                <div class="form-group" style="padding-left: 0rem;">
                  <div class='col-lg-12 error form-group'>
                    <div class='alert-success alert'>
                      {{ Session::get('success') }}
                    </div>
                  </div>
                </div>
                {{ Session::forget('success') }}
                @endif
              </form>
            </div>
            <div class="card-footer">
            </div>
        </div>
	</div>
</section>
@endsection

@section('pageJs')
@stop