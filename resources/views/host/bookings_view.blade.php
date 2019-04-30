@extends('layouts.hostLayout.hostApp')

@section('pageCss')
<style type="text/css">
  .small-box{padding:5px 10px;background-color:#ddf8ff;}
  .small-box a{text-decoration:none;color:#444;}
  .small-box:hover{color:inherit;cursor:pointer;background-color:#cceef7;}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
      @if(Session::get('status') == "success")
      <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <i class="icon fa fa-check"></i>{{ Session::get('message') }}
      </div>
      @elseif(Session::get('status') == "danger")
      <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <i class="icon fa fa-ban"></i>{{ Session::get('message') }}
      </div>
      @endif
      <div class="row">
        <div class="col-xs-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#booking_calendar_box" data-toggle="tab">Booking Calendar</a></li>
              <li><a href="#booking_table_box" data-toggle="tab">Booking Table</a></li>
            </ul>
            <div class="tab-content">
              <div id="booking_calendar_box" class="active tab-pane box-body">
                <div class="col-xs-12 col-lg-6" id="booking_calendar"></div>
                <div class="col-xs-12 col-lg-6" style="overflow-y:scroll; height:450px;">
                  @if(!$bookings->isEmpty())
                    @foreach($bookings as $b)
                      <div class="small-box">
                        <a href="#" class="get-booking-data" data-id="{{ $b['id'] }}" data-toggle="modal" data-target="#booking-data">
                          <h5>{{ Carbon::create($b['date'])->format('d/m/Y') }}</h5>
                          <div class="booking-box">
                            <p>{{ $b['getBookedListingUser']['title'] }}</p>
                            <p style="margin-left:auto;">{{ Carbon::create($b['getBookedListingTime']['start_time'])->format('g:i a') }}-{{ Carbon::create($b['getBookedListingTime']['end_time'])->format('g:i a') }}</p>
                          </div>
                          @if(Carbon::today() > $b['date'] && $b['getbookingStatus']['name'] != 'reserved' && $b['getbookingStatus']['name'] != 'cancelled')
                          <p style="color:red;">Requested booking date has passed.</p>
                          @else
                          <p style="color:red;">{{ $b['getbookingStatus']['display_name'] }}</p>
                          @endif
                        </a>
                      </div>
                    @endforeach
                  @else
                    <p>No Bookings.</p>
                  @endif
                </div>
              </div>
              <div id="booking_table_box"  class="tab-pane box-body">
                <table id="bookings_list" class="table table-bordered table-striped" style="width:100%;">
                  <thead>
                      <tr>
                        <th>Booking ID</th>
                        <th>Date of Booking</th>
                        <th>No of Seats</th>
                        <th>Time Slot</th>
                        <th>Status</th>
                        <th>Listing</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                        <th>Booking ID</th>
                        <th>Date of Booking</th>
                        <th>No of Seats</th>
                        <th>Time Slot</th>
                        <th>Status</th>
                        <th>Listing</th>
                        <th>Action</th>
                      </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
<div class="modal fade" id="booking-data" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Booking Details</h4>
      </div>
      <div class="modal-body" id="booking-content">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
  $(document).ready(function(){
    $('#booking_calendar').fullCalendar({
        header : {left  : '', center: 'title', right : 'prev,next'},
        selectable: true,
        events: function(start, end, timezone, callback) {
          $.ajax({
              url: "{{ url('host/bookings/get-bookings') }}",
              type: 'get',
              dataType: 'json',
              data: {
                  start: start.format(),
                  end: end.format()
              },
              success: function(doc) {
                var events = [];
                if(!!doc.bookings){
                    $.map(doc.bookings, function(r){
                        events.push({
                            id: r.id,
                            title: r.get_booked_listing_user.title,
                            description: "Time: "+r.time,
                            start: r.date,
                            end: r.date, 
                        });
                    });
                }
                callback(events);
              } 
          });
        },
        eventRender: function (eventObj, $el) {
            $el.popover({
                title: eventObj.title,
                content: eventObj.description,
                trigger: 'hover',
                placement: 'top',
                container: 'body'
            });
        },
    });

    $("a.get-booking-data").on("click", function(){
      var id = $(this).attr("data-id")
      $.ajax({
          url: "{{ url('host/bookings/get-booking-data') }}/"+id,
          type: 'get',
          dataType: 'json',
          success: function(data) {
            if(data.status =='success')
            {
              $("#booking-content").html(data.booking_data);
            }
          } 
      });
    });

    var table = $('#bookings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        order: [ 1, "asc" ],
        ajax: {
          "url": '{!! url("host/bookings/get-bookings-table") !!}',
          "type": 'GET',
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'date', name: 'date' },
            { data: 'no_of_seats', name: 'no_of_seats' },
            { data: 'time_slot', name: 'time_slot' },
            { data: 'status_id', name: 'status_id' },
            { data: 'listing_id', name: 'listing_id', orderable: false },
            { data: 'action', name: 'action', orderable: false },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
    });

    $(document).on("click", "a.confirmation", function(){
      var id = $(this).attr("data-id")
      
      if($(this).hasClass("btn-info")){
        data = 1;
        message = "Booking has been confirmed.";
        $(this).text("Revoke Confirmation");
        $(this).removeClass("btn-info").addClass("btn-default");
      }
      else if($(this).hasClass("btn-default")){
        data = 3;
        message = "Booking Confirmation has been revoked.";
        $(this).text("Confirm Booking");
        $(this).removeClass("btn-default").addClass("btn-info");
      }

      $.ajax({
          url: "{{ url('host/bookings/change-confirmation') }}/"+id+"/"+data,
          type: 'get',
          dataType: 'json',
          success: function(data) {
            if(data.status =='success')
            {
              swal({
                title: "Success",
                text: message,
                timer: 2000,
                type: "success",
                showConfirmButton: false
              });
            }
            else if(data.status == 'danger'){
              swal("Error", data.message, "warning");
            }
          } 
      });
      return false;
    });
  });
</script>
@stop