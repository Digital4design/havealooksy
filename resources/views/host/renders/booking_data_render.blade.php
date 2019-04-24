<div class="modal-row">
	<label>Booking ID</label>
	<p>{{ $booking['id'] }}</p>
</div>
<div class="modal-row">
	<label>Booked Listing</label>
	<p>{{ $booking['getBookedListingUser']['title'] }}</p>
</div>
<div class="modal-row">
	<label>Booking Date</label>
	<p>{{ Carbon::create($booking['date'])->format('d/m/Y') }}</p>
</div>
<div class="modal-row">
	<label>Number of Seats</label>
	<p>{{ $booking['no_of_seats'] }}</p>
</div>
<div class="modal-row">
	<label>Time Slot</label>
	<p>{{ Carbon::create($booking['getBookedListingTime']['start_time'])->format('g:i a') }}-{{ Carbon::create($booking['getBookedListingTime']['end_time'])->format('g:i a') }}</p>
</div>
<div class="modal-row">
	<label>Status</label>
	<p>{{ $booking['getBookingStatus']['display_name'] }}</p>
</div>