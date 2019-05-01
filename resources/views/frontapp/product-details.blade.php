@guest
  @php $layout = 'layouts.frontapp' @endphp
@endguest

@auth
  @php $layout = 'layouts.shopperLayout.shopperFrontApp' @endphp
@endauth

@extends($layout)

@section('pageCss')
<style type="text/css">
	td.fc-past{background-color: #eee;}
	td.fc-day:hover{background-color: rgba(137,43,225,0.4); cursor: pointer;}
	td.fc-day.fc-past:hover{background-color: #eee;cursor: not-allowed;}
	.fc-highlight{background-color: rgba(137,43,225,0.6);}
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
						  	<div class="tab-pane active" id="pic-{{$listing_data['getImages'][0]['id']}}"><img src="{{ asset('public/images/listings/'.$listing_data['getImages'][0]['name']) }}" /></div>
						  	@foreach($listing_data['getImages'] as $key => $img)
						  		<div class="tab-pane" id="pic-{{$img['id']}}"><img src="{{ asset('public/images/listings/'.$img['name']) }}" /></div>
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
						<h3 class="product-title">{{ $listing_data['title'] }}
							@if($wishlist == 0)
							<span class="add-to-wishlist"><a href="{{ url('/add-to-wishlist/'.$listing_data['id']) }}"><i class="glyphicon glyphicon-heart"></i>Add to Wishlist</a></span>
							@endif
						</h3>
						<div class="rating">
							@php $rating = $avg_rating['avg']; @endphp
							<div class="stars">
								@foreach(range(1,5) as $i)
									@if($rating > 0)
										@if($rating > 0.5)
											<span class="fa fa-star checked"></span>
										@else
											<span class="fa fa-star-half-o checked"></span>
										@endif
									@else
										<span class="fa fa-star-o"></span>
									@endif
									@php $rating--; @endphp
								@endforeach
							</div>
						</div>
						<h4 class="price"><span>${{ $listing_data['price'] }}</span></h4>
						<p class="product-description">{{ $listing_data['description'] }}</p>           
                        <div class="qty-main">
							<!-- <div class="qty">
								<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
								<input name="quantity" value="1" />
								<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
							</div> -->
							<div class="action">
								<a href="#" data-toggle="modal" data-target="#booking-calendar" class="add-to-cart btn btn-default">BUY THIS PRODUCT</a>						
							</div>
						</div>
						<p style="margin-top:10px;margin-bottom:0px;">LOCATION: {{ $listing_data['location'] }}</p>
						<p>CATEGORY : {{ $listing_data['getCategory']['name'] }}</p>
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

<section id="Reviews" class="Reviews">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="section-title">
					<h2>Customer Reviews</h2>
				</div>
			</div>
		</div>
		<div class="row">
		  	<div class="col-lg-12">
		  		@if(!$ratings_data->isEmpty())
		  			@foreach($ratings_data as $val)
		  			<div class="review-box">
		  				<div class="review-top">
		  					<img src="{{ ($val['getReviewer']['profile_picture']) ? asset('public/images/profile_pictures/'.$val['getReviewer']['profile_picture']) : asset('public/images/default-pic.png') }}">
		  					<div class="review-top-data">
		  						<h4>{{ $val['getReviewer']['first_name'] }} {{ $val['getReviewer']['last_name'] }}<span>{{ Carbon::create($val['created_at']->toDateTimeString())->format('F, Y') }}</span></h4>

		  						@php $rating = $val['rating']; @endphp
								<div class="stars" style="margin-left:10px;">
									@foreach(range(1,5) as $i)
										@if($rating > 0)
											@if($rating > 0.5)
												<span class="fa fa-star checked"></span>
											@else
												<span class="fa fa-star-half-o checked"></span>
											@endif
										@else
											<span class="fa fa-star-o"></span>
										@endif
										@php $rating--; @endphp
									@endforeach
								</div>
		  					</div>
		  				</div>
		  				<div class="review-bottom" style="margin-bottom:0px;">
		  					<p>{{ $val['review'] }}</p>
		  				</div>
		  			</div>
		  			@endforeach
				@else
					<p class="text-center" style="font-size:1.3em;">No reviews.</p>
				@endif
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
  	<div id="loading" class="hide" style="position:absolute;top:45%;left:45%;z-index:1111;">
	  <div class="loader"></div>
	</div>
    <div class="modal-content">
      <form id="booking_options" method="POST">
        @csrf
        <input type="hidden" name="listing_id" value="{{ $listing_data['id'] }}">
        <input type="hidden" name="date">
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
          	<div id="choose_details" style="display: none;margin-top: 10px;">
        	</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" style="border-radius:0;border:1px solid #999;cursor:pointer;" data-dismiss="modal">Close</button>
          <input type="submit" class="add-to-cart btn btn-default" value="Add To Cart" disabled="true">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
	$(document).ready(function(){
		// $(".btn-plus").on("click", function(){
		// 	var quantity = parseInt($("input[name=quantity]").val());
		// 	$("input[name=quantity]").val(quantity+1);
		// });
		// $(".btn-minus").on("click", function(){
		// 	var quantity = parseInt($("input[name=quantity]").val());
		// 	if(quantity != 1){
		// 		$("input[name=quantity]").val(quantity-1);
		// 	}
		// });
		
        $('#booking_calendar').fullCalendar({
          header : {left  : '', center: 'title', right : 'prev,next'},
          // selectable: true,

          dayClick: function (start, end, allDay, date, jsEvent, view) {
          	if(!start.isBefore(moment())) {

          		$(".fc-highlight").removeClass("fc-highlight");
        		$(this).addClass("fc-highlight");
        		$("input[name=date]").val($(this).attr('data-date'));

        		var clicked_date = Date.parse($(this).attr('data-date'))/1000;

        		var id = $("input[name=listing_id]").val();
        		$("#loading").toggleClass("hide");
          		$.ajax({
			        'url'        : '{{ url("get-products/product-availability") }}/'+id+"/"+clicked_date,
			        'method'     : 'get',
			        'dataType'   : 'json',
			        success    : function(resp){
			          
			            if(resp.status == 'success'){
			            	$("#loading").toggleClass("hide");
			              	$("#choose_details").css("display", "block");
							$("#choose_details").html(resp.listing_details);
				          	$(".calendar_details").css("justify-content", "normal");
				          	$(".select_date_to_proceed").css("display", "none");
				          	$(".add-to-cart").prop("disabled", false);

						    $(".times_group .time").on("click", function(){
						        $(".times_group .time").removeClass("btn-danger").addClass("btn-default");
						        $(this).removeClass("btn-default").addClass("btn-danger");
						    });

						    $(".guests_group .guest .btn-plus").on("click", function(){
								var quantity = parseInt($(this).parent(".guestcount").find(".guest_input").val());
								$(this).parent(".guestcount").find(".guest_input").val(quantity+1);
							});
							$(".guests_group .guest.adult .btn-minus").on("click", function(){
								var quantity = parseInt($(this).parent(".guestcount").find(".guest_input").val());
								if(quantity != 1){
									$(this).parent(".guestcount").find(".guest_input").val(quantity-1)
								}
							});
							$(".guests_group .guest.not-adult .btn-minus").on("click", function(){
								var quantity = parseInt($(this).parent(".guestcount").find(".guest_input").val());
								if(quantity != 0){
									$(this).parent(".guestcount").find(".guest_input").val(quantity-1)
								}
							});
			            }
			            else if(resp.status == 'empty'){
			              $("#loading").toggleClass("hide");	
			              swal("Not Available", resp.message, "warning");
			            }
			            else if(resp.status == 'danger'){
			              swal("Error", resp.message, "warning");
			            }
			        } 
			    });			
			}
          },
        });

        $("#booking_options").submit(function(){
        	$.ajax({
		        'url'        : '{{ url("/add-to-cart") }}',
		        'method'     : 'post',
		        'data'       : $(this).serialize(),
		        'dataType'   : 'json',
		        success    : function(data){
		          
		            if(data.status == 'success'){
		              swal({
		                title: "Success",
		                text: data.message,
		                timer: 3000,
		                type: "success",
		                showConfirmButton: false
		              });
		              setTimeout(function(){ 
		                  window.location.href = "{{ url('/cart') }}";
		              }, 3000);
		            }
		            else if(data.status == 'danger'){
		              swal("Error", data.message, "warning");
		            }
		            else if(data.status == 'login'){
		              window.location.href = "{{ url('/login') }}";
		            }
		            else{
		              console.log(data);
		    
		              $('.error').html('');
		              $('.error').parent().removeClass('has-error');
		                   $.each(data,function(key,value){
		                       if(value != ""){
		                          $("#error-"+key).text(value);
		                           $("#error-"+key).parent().addClass('has-error');
		                       }
		                   });
		            }
		        } 
		    });
		    return false;
        });
	});
</script>
@stop