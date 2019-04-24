@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  
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
                <div class="box">
                <div class="box-header">
                  <h3 class="box-title">All Bookings</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
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
                <!-- /.box-body -->
              </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('pageJs')
<script>
  $(document).ready(function(){     
    var table = $('#bookings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
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
  });
</script>
@stop