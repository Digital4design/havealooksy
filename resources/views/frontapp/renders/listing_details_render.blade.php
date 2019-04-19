<label>Choose Guests:</label>
<div class="guests_group">
	@if($guests['adults'] == 1)
	<div class="guest btn btn-default">
		<label>Adults</label>
		<input class="form-control" type="checkbox" name="guest[]" value="adults">
	</div>
	@endif
	@if($guests['children'] == 1)
	<div class="guest btn btn-default">
		<label>Children</label>
		<input class="form-control" type="checkbox" name="guest[]" value="children">
	</div>
	@endif
	@if($guests['infants'] == 1)
	<div class="guest btn btn-default">
		<label>Infants</label>
		<input class="form-control" type="checkbox" name="guest[]" value="infants">
	</div>
	@endif
	<div class="error" id="error-guest"></div>
</div>
<div id="no_of_seats">
	<label>Guests Count</label>
	<input type="number" class="form-control" name="no_of_seats" min="1" placeholder="Guests Count">
	<small class="help-text">Available Spots: {{ $guests['total_count'] }}</small>
	<div class="error" id="error-no_of_seats"></div>
</div>
<label>Choose Time Slot:</label>
<div class="times_group">
	@foreach($times as $val)
		<div class="time btn btn-default">
			<label>{{Carbon::createFromFormat('H:i:s', $val['start_time'])->format('H:i')}}-{{Carbon::createFromFormat('H:i:s', $val['end_time'])->format('H:i')}}</label>
			<input class="form-control" type="radio" name="time[]">
		</div>        				
	@endforeach
	<div class="error" id="error-time"></div>
</div>