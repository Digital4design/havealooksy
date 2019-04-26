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
                  <h3 class="box-title">All Orders</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="orders_list" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th></th>
                          <th>Order ID</th>
                          <th>Amount</th>
                          <th>Shopper</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th></th>
                          <th>Order ID</th>
                          <th>Amount</th>
                          <th>Shopper</th>
                          <th>Status</th>
                          <th></th>
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
    var table = $('#orders_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        ajax: {
          "url": '{!! url("admin/orders/get-orders") !!}',
          "type": 'GET',
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'order_number', name: 'order_number' },
            { data: 'order_amount', name: 'order_amount' },
            { data: 'user_id', name: 'user_id' },
            { data: 'order_status', name: 'order_status' },
            { data: 'order_items', name: 'order_items' },
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