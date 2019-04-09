@guest
  @php $layout = 'layouts.frontapp' @endphp
@endguest

@auth
  @php $layout = 'layouts.buyerLayout.buyerFrontApp' @endphp
@endauth

@extends($layout)

@section('content')
<section class="product-detail">
	<div class="container">
		<div class="card shopping-cart">
            <div class="card-header bg-dark text-light" style="font-weight:300;">
            	<i class="fa fa-shopping-cart" aria-hidden="true"></i><span style="margin-right:15px;"></span>Shopping Cart
                <a href="{{ url('/') }}" class="btn btn-outline-info btn-sm pull-right">Continue Shopping</a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <!-- PRODUCT -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2 text-center">
                        <img class="img-responsive" src="http://placehold.it/120x80" alt="prewiew" width="120" height="80">
                    </div>
                    <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                        <h4 class="product-name"><strong>Product Name</strong></h4>
                        <h4>
                            <small>Product description</small>
                        </h4>
                    </div>
                    <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                        <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                            <h5><strong>25.00<span class="text-muted"> x </span><span id="quantity_selected">1</span></strong></h5>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4">
                            <div class="quantity">
                                <input type="button" value="+" class="plus">
                                <input type="number" step="1" max="99" min="1" value="1" title="Qty" name="quantity" class="qty" size="4">
                                <input type="button" value="-" class="minus">
                            </div>
                        </div>
                        <div class="col-2 col-sm-2 col-md-2 text-right">
                            <button type="button" class="btn btn-outline-danger btn-xs">
                                <i class="fa fa-trash" aria-hidden="true" style="font-size:15px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- END PRODUCT -->
                <div class="pull-right">
                    <a href="" class="btn btn-outline-secondary pull-right">
                        Update shopping cart
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <div class="coupon col-md-5 col-sm-5 no-padding-left pull-left">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control" placeholder="Coupon code">
                        </div>
                        <div class="col-6">
                            <input type="submit" class="btn btn-default" value="Use Coupon">
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin: 0 10px">
                    <a href="{{ url('/checkout') }}" class="btn btn-success pull-right">Checkout</a>
                    <div class="pull-right" style="margin: 10px 20px;">
                        <!-- Total price: <b>50.00€</b> -->
                        <p style="color:#333;">Total price: <b>50.00€</b></p>
                    </div>
                </div>
            </div>
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