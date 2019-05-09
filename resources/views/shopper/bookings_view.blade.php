@extends('layouts.shopperLayout.shopperApp')

@section('pageCss')
<style type="text/css">
  .small-box{padding:5px 10px;background-color:#ddf8ff;margin-bottom:5px;}
  .small-box a{text-decoration:none;color:#444;}
  .small-box p, .small-box h5{margin:0px;}
  .small-box:hover{color:inherit;cursor:pointer;background-color:#cceef7;}
  .booking-inline{display:inline;}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Booking Calendar</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('shopper/dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bookings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @if(Session::get('status') == "success")
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ Session::get('message') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </a>
    </div>
    @elseif(Session::get('status') == "danger")
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ Session::get('message') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </a>
    </div>
    @endif
    <div class="row" style="height:500px;width:auto;">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card" style="height:500px;width:100%;">
            <div class="card-body">
              <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 booking-inline" id="booking_calendar" style="float:left;height:auto;"></div>
              <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 booking-inline" style="height:450px;float:right;">
                @if(!$bookings->isEmpty())
                  @foreach($bookings as $b)
                    <div class="small-box">
                      <a href="#" class="get-booking-data" data-id="{{ $b['id'] }}" data-toggle="modal" data-target="#booking-data">
                        <h5>{{ Carbon::create($b['date'])->format('d/m/Y') }}</h5>
                        <div class="booking-box">
                          <p>{{ $b['getBookedListingUser']['title'] }}</p>
                          <p style="margin-left:auto;">{{ Carbon::create($b['getBookedListingTime']['start_time'])->format('g:i a') }}-{{ Carbon::create($b['getBookedListingTime']['end_time'])->format('g:i a') }}</p>
                        </div>
                        <p style="color:red;">{{ $b['getBookingStatus']['display_name'] }}</p>
                      </a>
                    </div>
                  @endforeach
                  <span style="float:right;">{{ $bookings->links() }}</span>
                @else
                  <p>No Bookings.</p>
                @endif
              </div>
            </div>
          </div>
        </div> 
    </div>
</div>
<div class="modal fade" id="booking-data" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Booking Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body" id="booking-content">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light pull-left" data-dismiss="modal">Close</button>
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

    $("a.get-booking-data").on("click", function(){
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