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
                <h2 class="pageheader-title">All Orders</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Orders</li>
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
              <table id="orders_list" class="table table-bordered table-striped" style="width:100%;">
                <thead>
                    <tr>
                      <th></th>
                      <th>Order ID</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Shopper</th>
                      <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th></th>
                      <th>Order ID</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Shopper</th>
                      <th></th>
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
    $('#orders_list tfoot th:eq(1),#orders_list tfoot th:eq(2),#orders_list tfoot th:eq(3)').each(function(){
        var title = $(this).text();
        $(this).css('width', '10%');
        $(this).html('<input type="text" class="form-control search-column" style="font-weight:normal;" placeholder="Search '+title+'" />');
    });     
    var table = $('#orders_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        scrollX: true,
        ajax: {
          "url": '{!! url("admin/orders/get-orders") !!}',
          "type": 'GET',
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'order_number', name: 'order_number' },
            { data: 'order_amount', name: 'order_amount' },
            { data: 'order_status', name: 'order_status' },
            { data: 'user_id', name: 'user_id' },
            { data: 'order_items', name: 'order_items' },
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
  });
</script>
@stop