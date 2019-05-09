@extends('layouts.hostLayout.hostApp')

@section('pageCss')
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Booking List</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('host/dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Booking List</li>
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
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
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
@endsection

@section('pageJs')
<script type="text/javascript">
  $(document).ready(function(){
    $('#bookings_list tfoot th:eq(1),#bookings_list tfoot th:eq(2),#bookings_list tfoot th:eq(3),#bookings_list tfoot th:eq(4)').each(function(){
        var title = $(this).text();
        $(this).css('width', '10%');
        $(this).html('<input type="text" class="form-control search-column" style="font-weight:normal;" placeholder="Search '+title+'" />');
    });

    var table = $('#bookings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        scrollX: true,
        order: [ 1, "asc" ],
        ajax: {
          "url": '{!! url("host/bookings/booking-list/get-bookings-table") !!}',
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

    /* Individual column search */
    table.columns().every(function(){
        var that = this;
 
        $('input', this.footer()).on('keyup change', function(){
            if (that.search() !== this.value){
                that
                    .search(this.value)
                    .draw();
            }
        });
    });

    $(document).on("click", "a.confirmation", function(){
      var id = $(this).attr("data-id")
      
      if($(this).hasClass("btn-info")){
        data = 1;
        message = "Booking has been confirmed.";
      }
      else if($(this).hasClass("btn-light")){
        data = 3;
        message = "Booking Confirmation has been revoked.";
      }

      $("#loading").toggleClass("hide");
      $.ajax({
          url: "{{ url('host/bookings/booking-list/change-confirmation') }}/"+id+"/"+data,
          type: 'get',
          dataType: 'json',
          success: function(data) {
            $("#loading").toggleClass("hide");
            if(data.status =='success')
            {
              swal({
                title: "Success",
                text: message,
                timer: 2000,
                type: "success",
                showConfirmButton: false
              });

              setTimeout(function(){ 
                location.reload();
              }, 2000);
            }
            else if(data.status == 'danger'){
              swal("Error", data.message, "warning");
            }
          } 
      });
      return false;
    });

    $(document).on("click", "a.cancel_booking", function(){
      var id = $(this).attr("data-id")
      
      if($(this).hasClass("btn-danger")){
        data = 4;
        message = "Booking has been cancelled.";
      }
      else if($(this).hasClass("btn-teal")){
        data = 3;
        message = "Booking Cancellation has been revoked.";
      }

      $("#loading").toggleClass("hide");
      $.ajax({
          url: "{{ url('host/bookings/booking-list/cancel') }}/"+id+"/"+data,
          type: 'get',
          dataType: 'json',
          success: function(data) {
            $("#loading").toggleClass("hide");
            if(data.status =='success')
            {
              swal({
                title: "Success",
                text: message,
                timer: 2000,
                type: "success",
                showConfirmButton: false
              });

              setTimeout(function(){ 
                location.reload();
              }, 2000);
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