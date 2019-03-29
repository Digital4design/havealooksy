@foreach($listings_list as $listings)
	@if(!$listings->isEmpty())
		@foreach($listings as $val)
		<!-- team member item -->
		<div class="col-md-3 product-link grid_view">
			<a href="{{ url('home/get-products/product-details/'.$val['id']) }}">
				<div class="team-item">
					<div class="team-image">
						<img src="{{ asset('public/images/listings/'.$val['image']) }}" class="img-responsive" alt="author">
					</div>
					<div class="team-text">
					    <div class="team-name">RESTAURANT</div> 
						<h3>{{ $val['title'] }}</h3>
						<p>${{ $val['price'] }} per person</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-9 product-link list_view" style="display:none;">
			<a href="{{ url('home/get-products/product-details/'.$val['id']) }}">
				<div class="team-item">
					<div class="team-image" style="width:30%;">
						<img src="{{ asset('public/images/listings/'.$val['image']) }}" class="img-responsive" alt="author">
					</div>
					<div class="team-text"  style="width:60%;margin-left:20px;">
					    <div class="team-name" style="margin-bottom:12px;">RESTAURANT</div> 
						<h4 style="display:inline;">{{ $val['title'] }}</h4><span class="pull-right" style="color:#232323;font-size:15px;text-decoration:none;display:inline;">${{ $val['price'] }} per person</span>
						<p class="product_description">{{ $val['description'] }}</p>
					</div>
				</div>
			</a>
		</div>
		<!-- end team member item -->
		@endforeach
	@endif
@endforeach