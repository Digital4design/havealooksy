@extends('layouts.frontapp')

@section('content')
<section class="product-detail">
	<div class="container">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1" style="position:relative;width:100%;height:600px;"><img src="{{ asset('public/images/listings/'.$listing_data['image']) }}" style="position:absolute;height:100%;width:100%;" /></div>

						  <!-- <div class="tab-pane active" id="pic-1"><img src="{{ asset('public/images/listings/'.$listing_data['image']) }}" /></div> -->
						</div>
						<ul class="preview-thumbnail nav nav-tabs">
						  <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="{{ asset('public/images/listings/'.$listing_data['image']) }}" /></a></li>
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
								<input value="1" />
								<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
							</div>
							<div class="action">
								<button class="add-to-cart btn btn-default" type="button">Add To Cart</button>							
							</div>
						</div>
						<p class="vote">CATEGORY : {{ $listing_data['getCategory']['name'] }}</p>
						<div class="action">				
							<a href="{{ url('buyer/chat/get-chat/'.$listing_data['user_id']) }}" class="like btn btn-default"><i class="fa fa-comment"></i>Message Us</a>
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
				<div class="owl-carousel">
					@if(!$all_listings->isEmpty())
						@foreach($all_listings as $val)
						<!-- start portfolio item -->
						<div class="item">
							<!-- <a href="{{ url('home/get-products/product-details/'.$val['id']) }}"> -->
								<div class="ot-portfolio-item">
									<figure class="effect-bubba">
										<img src="{{ asset('public/images/listings/'.$val['image']) }}" alt="img02" class="img-responsive" />
										<figcaption>
											<h2>{{ $val['title'] }}</h2>
											<p>{{ $val['description'] }}</p>
											<a href="#" data-toggle="modal" data-target="#Modal-1">View more</a>
										</figcaption>
									</figure>
								</div>
							<!-- </a> -->
						</div>
						<!-- end portfolio item -->
						@endforeach
					@else
						<p>No matches found.</p>
					@endif
				</div>
			</div>
		</div>
	</div><!-- end container -->
</section>
@endsection