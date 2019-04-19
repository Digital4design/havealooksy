<div class="guests_group">
	@if($guests['adults'] == 1)
	<div class="qty guest">
		<label>Adults</label>
		<div class="guestcount">
			<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
			<input class="guest_input" name="guest['adults']" value="1">
			<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	</div>
	@endif
	@if($guests['children'] == 1)
	<div class="qty guest">
		<label>Children</label>
		<div class="guestcount">
			<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
			<input class="guest_input" name="guest['children']" value="1">
			<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	</div>
	@endif
	@if($guests['infants'] == 1)
	<div class="qty guest">
		<label>Infants</label>
		<div class="guestcount">
			<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
			<input class="guest_input" name="guest['infants']" value="1">
			<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	</div>
	@endif
</div>
<small class="help-text text-center" style="display:block;margin-bottom:30px;">(Available Spots: {{ $guests['total_count'] }})</small>
<p class="text-center" style="margin:10px;"><b>Choose Time Slot:</b></p>
<div class="times_group">
	@foreach($times as $val)
		<div class="time btn btn-default">
			<label>{{Carbon::createFromFormat('H:i:s', $val['start_time'])->format('H:i')}}-{{Carbon::createFromFormat('H:i:s', $val['end_time'])->format('H:i')}}</label>
			<input class="form-control" type="radio" name="time[]">
		</div>        				
	@endforeach
</div>