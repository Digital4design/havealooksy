<div class="rating-input" style="margin-bottom:20px;">
  <label>Rating</label>
  <!-- <p>{{ $data['rating'] }}</p> -->
	@php $rating = $data['rating']; @endphp  
 	<div class="rating-row">
 		@foreach(range(1,5) as $i)
			@if($rating > 0)
				@if($rating > 0.5)
					<i class="fa fa-star"></i>
				@else
					<i class="fa fa-star-half-o"></i>
				@endif
			@else
				<i class="fa fa-star-o"></i>
			@endif
			@php $rating--; @endphp
		@endforeach
 	</div>
</div>
<div class="rating-input">
  <label>Review</label>
  <p>{{ $data['review'] }}</p>
</div>
<div class="rating-input">
	@if($data['approved'] == 1)
	<p style="color:green;"><small>*Review Approved</small></p>
	@else
	<p style="color:red;"><small>*Review Not Approved</small></p>
	@endif
</div>