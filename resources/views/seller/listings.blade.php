@extends('layouts.sellerLayout.sellerApp')

@section('pageCss')
<style type="text/css">
  #add-listing-button{margin:1em auto;font-size:20px;padding:0.3em 1.5em;}
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
              <div class="pull-right">
                <a id="add-listing-button" href="{{ url('/seller/listings/add-listing') }}" class="btn btn-block btn-primary"><i class="fa fa-plus-circle"></i></a>
              </div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                <div class="box-header">
                  <h3 class="box-title">All Listings</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="listings_list" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Location</th>
                          <th>Price</th>
                          <th>Category</th>
                          <th>Status</th>
                          <!-- <th>Activate/Deactivate</th>
                          <th>Action</th> -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Location</th>
                          <th>Price</th>
                          <th>Category</th>
                          <th>Status</th>
                          <!-- <th>Activate/Deactivate</th>
                          <th>Action</th> -->
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
$(function() {
    $('#listings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        ajax: {
          "url": '{!! url("seller/listings/get-listings") !!}',
          "type": 'GET',
          "data": function (data) {
                data.title = "{{ (!empty($title))? $title : null }}";
                data.description = "{{ (!empty($description))? $description : null }}";
                data.location = "{{ (!empty($location)) ? $location : null }}";
                data.price = "{{ (!empty($price))? $price : null }}";
                data.category = "{{ (!empty($category))? $category : null }}";
                data.status = "{{ (!empty($status))? $status : null }}";
          }
        },
        columns: [
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'location', name: 'location' },
            { data: 'price', name: 'price' },
            { data: 'category', name: 'category' },
            { data: 'status', name: 'status' },
            // { data: 'activate_deactivate', name: 'activate_deactivate', orderable: false },
            // { data: 'action', name: 'action', orderable: false },
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