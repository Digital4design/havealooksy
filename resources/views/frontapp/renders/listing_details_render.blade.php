<div class="guests_group">
	@if($guests['adults'] == 1)
	<div class="qty guest adult">
		<label>Adults</label>
		<div class="guestcount">
			<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
			<input class="guest_input" name="guest[adults]" value="1">
			<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	</div>
	@endif
	@if($guests['children'] == 1)
	<div class="qty guest not-adult">
		<label>Children</label>
		<div class="guestcount">
			<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
			<input class="guest_input" name="guest[children]" value="0">
			<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	</div>
	@endif
	@if($guests['infants'] == 1)
	<div class="qty guest not-adult">
		<label>Infants</label>
		<div class="guestcount">
			<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
			<input class="guest_input" name="guest[infants]" value="0">
			<div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	</div>
	@endif
</div>
<small class="help-text text-center" style="display:block;margin-bottom:30px;">(Guest Limit: {{ $guests['total_count'] }})</small>
<p class="text-center" style="margin:10px;"><b>Choose Time Slot:</b></p>
<div class="times_group">
	@foreach($times as $val)
		@if($val['seats_left'] != 0)
			<div class="time btn btn-default">
				@php $time_slot =  Carbon::createFromFormat('H:i:s', $val['start_time'])->format('g:i a').'-'.Carbon::createFromFormat('H:i:s', $val['end_time'])->format('g:i a'); @endphp
				<label>{{ $time_slot }}<small class="help-text" style="display:block;font-size:9px;">({{ $val['seats_left'] }} seats left)</small></label>
				<input class="form-control" type="radio" value="{{ $val['id'] }}" name="time">
			</div>
		@endif        				
	@endforeach
	<span class="error" id="error-time"></span>
</div>