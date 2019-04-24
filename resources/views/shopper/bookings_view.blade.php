@extends('layouts.shopperLayout.shopperApp')

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
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Booking Calendar</h3>
            </div>
            <div class="box-body">
              <div class="col-xs-12 col-lg-6" id="booking_calendar"></div>
              <div class="col-xs-12 col-lg-6">
                @if(!$bookings->isEmpty())
                  @foreach($bookings as $b)
                    <div class="small-box">
                      <a href="#" id="get-booking-data" data-id="{{ $b['id'] }}" data-toggle="modal" data-target="#booking-data">
                        <h5>{{ Carbon::create($b['date'])->format('d/m/Y') }}</h5>
                        <div class="booking-box">
                          <p>{{ $b['getBookedListingUser']['title'] }}</p>
                          <p style="margin-left:auto;">{{ Carbon::create($b['getBookedListingTime']['start_time'])->format('g:i a') }}-{{ Carbon::create($b['getBookedListingTime']['end_time'])->format('g:i a') }}</p>
                        </div>
                        <p style="color:red;">{{ $b['getBookingStatus']['display_name'] }}</p>
                      </a>
                    </div>
                  @endforeach
                @else
                  <p>No Bookings.</p>
                @endif
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
              url: "{{ url('shopper/bookings/get-bookings') }}",
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
                            description: "Status: "+r.get_booking_status.display_name,
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

    function newLine(display_txt)
    {
      display_txt = display_txt.replace(/\n/g, "<br />");
      return display_txt;
    }

    $("#get-booking-data").on("click", function(){
      var id = $(this).attr("data-id")
      $.ajax({
          url: "{{ url('shopper/bookings/get-booking-data') }}/"+id,
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
  });
</script>
@stop