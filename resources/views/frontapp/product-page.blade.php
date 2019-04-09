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
			<div class="col-lg-3">
				<div class="filter-content">
					<strong class="text-left">Price</strong>
					<div class="card-body">
						<form id="apply_filters_form" method="POST">
							@csrf
							<input type="hidden" name="category_id" value="{{ $category['id'] }}">
							<div class="from-group">
								<label class="form-check">
								  <input class="form-check-input" type="checkbox" value="0-100" name="price_filter[]">
								  <span class="form-check-label">
								    0$ -  100$
								  </span>
								</label> <!-- form-check.// -->
								<label class="form-check">
								  <input class="form-check-input" type="checkbox" value="100-500" name="price_filter[]">
								  <span class="form-check-label">
								    100$ - 500$
								  </span>
								</label>  <!-- form-check.// -->
								<label class="form-check">
								  <input class="form-check-input" type="checkbox" value="500-1000" name="price_filter[]">
								  <span class="form-check-label">
								    500$-1000$
								  </span>
								</label>  <!-- form-check.// -->
								<label class="form-check">
								  <input class="form-check-input" type="checkbox" value="1000-2000" name="price_filter[]">
								  <span class="form-check-label">
								    1000$-2000$
								  </span>
								</label>  <!-- form-check.// -->
								<div class="error" id="error-price_filter"></div>
							</div>
							<div class="form-group">
								<button id="filter_form_button" type="submit" class="btn btn-block">Apply</button>
							</div>
						</form>
					</div> <!-- card-body.// -->
				</div>
			</div>
			<div class="col-lg-9">
				<div class="row">
					<div class="col-lg-12 ">
						<div class="well well-sm">
							<strong class="text-left">{{ $category['name'] }}</strong>
							<div class="view-main">
								<div class="btn-group">
								<a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
								</span>List</a> <a href="#" id="grid" class="btn btn-default btn-sm on_click_css"><span class="glyphicon glyphicon-th"></span>Grid</a>
								</div>
							</div>	
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
						<a href="{{ url('get-products/product-details/'.$val['id']) }}">
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
				@else
					<p>No matches found.</p>
				@endif
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('pageJs')
	<script type="text/javascript">
		$(document).ready(function(){
			$("#grid").trigger("click");
			$("#grid").on("click", function(e){
				e.preventDefault();
				$("#list").toggleClass("on_click_css");
				$("#grid").toggleClass("on_click_css");
				$(".list_view").css("display", "none");
				$(".grid_view").css("display", "block");
			});
			$("#list").on("click", function(e){
				e.preventDefault();
				$("#grid").toggleClass("on_click_css");
				$("#list").toggleClass("on_click_css");
				$(".list_view").css("display", "block");	
				$(".grid_view").css("display", "none");	
			});

			$("#apply_filters_form").submit(function(){
				$.ajax({
			      'url'      : "{{ url('get-products/apply-filters') }}",
			      'method'   : 'post',
			      'dataType' : 'json',
			      'data'     : $(this).serialize(),
			      success    : function(data){

			        if(data.status == 'success'){
			          $("#listings_list").html(data.filtered_listings);
			        }
			        else if(data.status == 'danger'){
			          $("#listings_list").html("<p>"+data.message+"</p>");
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