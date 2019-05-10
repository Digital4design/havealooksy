@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">All Bookings</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
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
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
              <table id="bookings_list" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>Booking ID</th>
                      <th>Date of Booking</th>
                      <th>No of Seats</th>
                      <th>Time Slot</th>
                      <th>Status</th>
                      <th>Listing</th>
                      <th>User</th>
                      <th>Created At</th>
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
                      <th>User</th>
                      <th>Created At</th>
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
<script>
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
          "url": '{!! url("admin/bookings/get-bookings") !!}',
          "type": 'GET',
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'date', name: 'date' },
            { data: 'no_of_seats', name: 'no_of_seats' },
            { data: 'time_slot', name: 'time_slot' },
            { data: 'status_id', name: 'status_id' },
            { data: 'listing_id', name: 'listing_id', orderable: false },
            { data: 'user_id', name: 'user_id', orderable: false },
            { data: 'created_at', name: 'created_at' },
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

    $(document).on("click", "a.cancel_booking", function(){
      var id = $(this).attr("data-id");

      $("#loading").toggleClass("hide");
      $.ajax({
        'url'      : '{{ url("admin/bookings/cancel-booking") }}/'+id,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            
            $("#loading").toggleClass("hide");
            swal({
                title: "Success",
                text: data.message,
                timer: 2000,
                type: "success",
                showConfirmButton: false
            });

            setTimeout(function(){ 
              location.reload();
            }, 2000);
          }  
        } 
      });
    });
  });
</script>
@stop