@guest
  @php $layout = 'layouts.frontapp' @endphp
@endguest

@auth
  @php $layout = 'layouts.buyerLayout.buyerFrontApp' @endphp
@endauth

@extends($layout)

@section('pageCss')
<style type="text/css">
	.product-link{transition: transform 0.3s;}
	.product-link:hover{transform: scale(1.05);}
	.on_click_css,#filter_form_button:hover{color: #fff;background-color: #6e1cba;border-color: #6e1cba;}
	#filter_form_button{border:1px solid #6e1cba;color:#6e1cba;margin:12px auto;background-color:transparent;}
	#filter_form_button:active:focus{background-color: #d4d4d4;border-color: #8c8c8c;}
	.add_margin{margin-left:20px;}
	.btn-default:hover{color:#fff !important;}
	.btn:focus {outline: none;}
	.error{color:red;font-size:12px;}
</style>
@stop

@section('content')		
<section id="category-same" class="listing-page">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12 ">
						<div class="well well-sm">
							<strong class="text-left">Search Results...</strong>	
						</div>
					</div>	
				</div>
				<div class="row" id="listings_list">
				@if(!$listings->isEmpty())
					@foreach($listings as $val)
					<!-- team member item -->
					<div class="col-md-3 product-link grid_view">
						<a href="{{ url('get-products/product-details/'.$val['id']) }}" target="_blank">
							<div class="team-item">
								<div class="team-image" style="height:100%;">
									<img src="{{ asset('public/images/listings/'.$val['image']) }}" class="img-responsive" alt="author">
								</div>
								<div class="team-text">
								    <div class="team-name">RESTAURANT</div> 
									<h3>{{ $val['title'] }}</h3>
									<p>${{ $val['price'] }} per person</p>
									<p>CATEGORY : {{ $val['getCategory']['name'] }}</p>
								</div>
							</div>
						</a>
					</div>
					<!-- end team member item -->
					@endforeach
				@else
					<div class="col-lg-12">
						<p>No matches found.</p>
					</div>
				@endif
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('pageJs')
@stop