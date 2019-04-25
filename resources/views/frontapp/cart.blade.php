@guest
  @php $layout = 'layouts.frontapp' @endphp
@endguest

@auth
  @php $layout = 'layouts.shopperLayout.shopperFrontApp' @endphp
@endauth

@extends($layout)

@section('content')
<section class="product-detail">
	<div class="container">
		<div class="card shopping-cart">
            @if($status == 'not-empty')
            <div class="card-header bg-dark text-light" style="font-weight:300;">
            	<i class="fa fa-shopping-cart" aria-hidden="true"></i><span style="margin-right:15px;"></span>Shopping Cart
                <a href="{{ url('/') }}" class="btn btn-outline-info btn-sm pull-right">Continue Shopping</a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                @php $total = 0 @endphp
                @foreach($data as $d)
                <!-- PRODUCT -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2 text-center">
                        <img class="img-responsive" src="{{ asset('public/images/listings/'.$d['attributes']['image']) }}" alt="{{ $d['name'] }}" width="120" height="80">
                    </div>
                    <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                        <h4 class="product-name"><strong>{{ $d['name'] }}</strong></h4>
                        <h4>
                            <small>{{ $d['attributes']['description'] }}</small>
                        </h4>
                        <div style="padding-top:20px;">
                            <h4>
                                <small>
                                    <b>Guests:</b> Adults({{ $d['attributes']['adults'] }}), Children({{ $d['attributes']['children'] }}), Infants({{ $d['attributes']['infants'] }})
                                </small>
                            </h4>
                            <h4>
                                <small><b>Time Slot:</b> {{ $d['attributes']['time_slot'] }}</small>
                            </h4>
                        </div>
                        @if($d['status'] == 'pending')
                        @php $total += $d['price']; @endphp
                        @elseif($d['status'] == 'waiting')
                            <h4><small><b style="color:red;">Awaiting Confirmation.</b></small></h4>
                        @endif
                    </div>
                    <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                        <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                            <h5><strong>${{ $d['price'] }}<!-- <span class="text-muted"> x </span><span id="quantity_selected">{{ $d['quantity'] }}</span> --></strong></h5>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4">
                            <!-- <div class="quantity">
                                <input type="button" value="+" class="plus">
                                <input type="number" step="1" max="99" min="1" value="{{ $d['quantity'] }}" title="Qty" name="quantity" class="qty" size="4">
                                <input type="button" value="-" class="minus">
                            </div> -->
                        </div>
                        <div class="col-2 col-sm-2 col-md-2 text-right">
                            <form method="POST" action="{{ url('/remove-from-cart') }}">
                                @csrf
                                <input type="hidden" name="cart_item_id" value="{{ $d['id'] }}">
                                <button type="submit" class="btn btn-outline-danger btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true" style="font-size:15px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- END PRODUCT -->
                @endforeach
                <!-- <div class="pull-right">
                    <a href="" class="btn btn-outline-secondary pull-right">
                        Update shopping cart
                    </a>
                </div> -->
            </div>
            <div class="card-footer">
                <div class="coupon col-md-5 col-sm-5 no-padding-left pull-left">
                    <!-- <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control" placeholder="Coupon code">
                        </div>
                        <div class="col-6">
                            <input type="submit" class="btn btn-default" value="Use Coupon">
                        </div>
                    </div> -->
                </div>
                <div class="pull-right" style="margin: 0 10px">
                    @if($total != 0)
                    <a href="{{ url('/checkout') }}" class="btn btn-success pull-right">Checkout</a>
                    @endif
                    <div class="pull-right" style="margin: 10px 20px;">
                        <!-- Total price: <b>50.00€</b> -->
                        <p style="color:#333;">Total price: <b>${{ $total }}</b></p>
                    </div>
                </div>
            </div>
            @else
                <div class="text-center">
                    <p>{{ $data }}</p>
                    <a href="{{ url('/') }}" class="btn btn-outline-info btn-sm">Continue Shopping</a>
                </div>
            @endif
        </div>
	</div>
</section>
@endsection

@section('pageJs')
<script type="text/javascript">
	$(document).ready(function(){
		$(".plus").on("click", function(){
			var quantity = parseInt($("input[name=quantity]").val());
			$("input[name=quantity]").val(quantity+1);
			$("#quantity_selected").text(quantity+1);
			return false;
		});
		$(".minus").on("click", function(){
			var quantity = parseInt($("input[name=quantity]").val());
			if(quantity != 1){
				$("input[name=quantity]").val(quantity-1);
				$("#quantity_selected").text(quantity-1);
			}
			return false;
		});
	});
</script>
@stop