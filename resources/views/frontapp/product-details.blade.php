@guest
  @php $layout = 'layouts.frontapp' @endphp
@endguest

@auth
  @php $layout = 'layouts.shopperLayout.shopperFrontApp' @endphp
@endauth

@extends($layout)

@section('pageCss')
<style type="text/css">
	td.fc-past{background-color: #EEEEEE;}
	td.fc-past:hover{cursor: not-allowed;}
</style>
@stop

@section('content')
<section class="product-detail">
	<div class="container">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						<div class="preview-pic tab-content">
						  	<div class="tab-pane active" id="pic-{{$listing_data['getImages'][0]['id']}}" style="position:relative;width:100%;height:600px;"><img src="{{ asset('public/images/listings/'.$listing_data['getImages'][0]['name']) }}" style="position:absolute;height:100%;width:100%;" /></div>
						  	@foreach($listing_data['getImages'] as $key => $img)
						  		<div class="tab-pane" id="pic-{{$img['id']}}" style="position:relative;width:100%;height:600px;"><img src="{{ asset('public/images/listings/'.$img['name']) }}" style="position:absolute;height:100%;width:100%;" /></div>
						  	@endforeach

						  <!-- <div class="tab-pane active" id="pic-1"><img src="{{ asset('public/images/listings/'.$listing_data['image']) }}" /></div> -->
						</div>
						<ul class="preview-thumbnail nav nav-tabs">
							<li class="active" style="margin-bottom:5px;"><a href="#" data-target="#pic-{{$listing_data['getImages'][0]['id']}}" data-toggle="tab"><img src="{{ asset('public/images/listings/'.$listing_data['getImages'][0]['name']) }}" /></a></li>
							@foreach($listing_data['getImages'] as $key => $img)
								@if($key != 0)
							        <li style="margin-bottom:5px;"><a href="#" data-target="#pic-{{$img['id']}}" data-toggle="tab"><img src="{{ asset('public/images/listings/'.$img['name']) }}" /></a></li>
							    @endif
						  	@endforeach
						</ul>	
					</div>
					<div class="details col-md-6">
						<h3 class="product-title">{{ $listing_data['title'] }}</h3>
						<div class="rating">
							<div class="stars">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
							</div>
						</div>
						<h4 class="price"><span>${{ $listing_data['price'] }}</span></h4>
						<p class="product-description">{{ $listing_data['description'] }}</p>           
                        <div class="qty-main">
							<div class="qty">
								<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
								<input name="quantity" value="1" />
								<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
							</div>
							<div class="action">
								<a href="#" data-toggle="modal" data-target="#booking-calendar" class="add-to-cart btn btn-default">BUY THIS PRODUCT</a>							
							</div>
						</div>
						<p class="vote">CATEGORY : {{ $listing_data['getCategory']['name'] }}</p>
						<div class="action">
							<a href="{{ url('/messages/chat/'.$listing_data['user_id']) }}" class="like btn btn-default"><i class="fa fa-comment"></i>Message Us</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!------------------------------------------->	
	
<section id="Favorites" class="Related_Products" >
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="section-title">
					<h2>Related Products</h2>
				</div>
			</div>
		</div>
		<div class="row">
		  	<div class="col-lg-12 text-center slider-cat">
		  		@if(!$all_listings->isEmpty())
		  			<div class="owl-carousel">
						@foreach($all_listings as $val)
						<!-- start portfolio item -->
						<div class="item">
							<div class="ot-portfolio-item">
								<figure class="effect-bubba">
									<img src="{{ asset('public/images/listings/'.$val['getImages'][0]['name']) }}" alt="img02" class="img-responsive" />
									<figcaption>
										<h2>{{ $val['title'] }}</h2>
										<p>{{ $val['description'] }}</p>
										<a href="{{ url('get-products/product-details/'.$val['id']) }}" style="padding:180px 50px;">View more</a>
									</figcaption>
								</figure>
							</div>
						</div>
						<!-- end portfolio item -->
						@endforeach
					</div>
				@else
					<p>No matches found.</p>
				@endif
			</div>
		</div>
	</div><!-- end container -->
</section>
<div class="modal fade" id="booking-calendar" style="display: none;">
  <div class="modal-dialog calendar-dialog">
    <div class="modal-content">
      <form id="booking_options" method="POST">
        @csrf
        <input type="hidden" name="listing_id" value="{{ $listing_data['id'] }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Choose Booking Details</h4>
        </div>
        <div class="modal-body calendar_body" style="padding:10px 20px;">
          <div class="form-group calendar">
            <div id="booking_calendar"></div>
          </div>
          <div class="form-group calendar_details">
          	<h4 class="select_date_to_proceed"><b>Select a Date to Proceed.</b></h4>
          	<div id="choose_details" style="display: none;">
        	</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add To Cart</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
	$(document).ready(function(){
		$(".btn-plus").on("click", function(){
			var quantity = parseInt($("input[name=quantity]").val());
			$("input[name=quantity]").val(quantity+1);
		});
		$(".btn-minus").on("click", function(){
			var quantity = parseInt($("input[name=quantity]").val());
			if(quantity != 1){
				$("input[name=quantity]").val(quantity-1);
			}
		});
		$(".guests_group .guest").on("click", function(){
	        $(this).toggleClass("btn-danger");
	    });
	    $(".times_group .time").on("click", function(){
	        $(".times_group .time").removeClass("btn-danger").addClass("btn-default");
	        $(this).removeClass("btn-default").addClass("btn-danger");
	    });
        $('#booking_calendar').fullCalendar({
          header : {left  : '', center: 'title', right : 'prev,next'},
          // selectable: true,

          dayClick: function (start, end, allDay, date, jsEvent, view) {
          	if(!start.isBefore(moment())) {

          		$(".fc-highlight").removeClass("fc-highlight");
        		$(this).addClass("fc-highlight");

        		var id = $("input[name=listing_id]").val();

          		$.ajax({
			        'url'        : '{{ url("get-products/product-availability") }}/'+id,
			        'method'     : 'get',
			        'dataType'   : 'json',
			        success    : function(resp){
			          
			            if(resp.status == 'success'){
			              	$("#choose_details").css("display", "block");
							$("#choose_details").html(resp.listing_details);
				          	$(".calendar_details").css("justify-content", "normal");
				          	$(".select_date_to_proceed").css("display", "none");
			            }
			            else if(resp.status == 'danger'){
			              swal("Error", resp.message, "warning");
			            }
			        } 
			    });			
			}
          },
        });
	});
</script>
@stop