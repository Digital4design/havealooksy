<div id="no_of_seats">
	<label>Seats Available:</label>
	<span><b>{{ $guests['total_count'] }}</b></span>
</div>
<label>Choose Guests:</label>
<div class="guests_group">
	@if($guests['adults'] == 1)
	<div class="guest btn btn-default">
		<input class="form-control" type="checkbox" name="guest[]">
		<label>Adults</label>
	</div>
	@endif
	@if($guests['children'] == 1)
	<div class="guest btn btn-default">
		<input class="form-control" type="checkbox" name="guest[]">
		<label>Children</label>
	</div>
	@endif
	@if($guests['infants'] == 1)
	<div class="guest btn btn-default">
		<input class="form-control" type="checkbox" name="guest[]">
		<label>Infants</label>
	</div>
	@endif
</div>
<label>Choose Time Slot:</label>
<div class="times_group">
	@foreach($times as $val)
		<div class="time btn btn-default">
			<input class="form-control" type="radio" name="time[]">
			<label>{{Carbon::createFromFormat('H:i:s', $val['start_time'])->format('H:i')}}-{{Carbon::createFromFormat('H:i:s', $val['end_time'])->format('H:i')}}</label>
		</div>        				
	@endforeach
</div>