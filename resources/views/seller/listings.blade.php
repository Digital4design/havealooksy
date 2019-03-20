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
                          <!-- <th>Status</th> -->
                          <th>Image</th>
                          <th>Activate/Deactivate</th>
                          <th>Action</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Location</th>
                          <th>Price</th>
                          <th>Category</th>
                          <!-- <th>Status</th> -->
                          <th>Image</th>
                          <th>Activate/Deactivate</th>
                          <th>Action</th>
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
                // data.status = "{{ (!empty($status))? $status : null }}";
          }
        },
        columns: [
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'location', name: 'location' },
            { data: 'price', name: 'price' },
            { data: 'category', name: 'category' },
            // { data: 'status', name: 'status' },
            { data: 'image', name: 'image', orderable: false },
            { data: 'activate_deactivate', name: 'activate_deactivate', orderable: false },
            { data: 'action', name: 'action', orderable: false },
            { data: 'is_favorite', name: 'is_favorite', orderable: false },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
    });

    $(document).on("click", "button.active-deactive", function(){
      var id = $(this).attr('data-id');

      if($(this).hasClass("btn-danger")){
        status_data = 1;
      }
      if($(this).hasClass("btn-default")){
        status_data = 0;
      }

      $.ajax({
        'url'      : '{{ url("seller/listings/change-status") }}/'+id+"/"+status_data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            if(data.listing_status == 1){
              $(".active-deactive[data-id="+id+"]").removeClass("btn-danger").addClass("btn-default").text("Deactivate");
              // $(".active-deactive[data-id="+id+"]").closest("tr").find("td:eq(5)").text("Active");
            }
            if(data.listing_status == 0){
              $(".active-deactive[data-id="+id+"]").removeClass("btn-default").addClass("btn-danger").text("Activate");
              // $(".active-deactive[data-id="+id+"]").closest("tr").find("td:eq(5)").text("Deactive");
            }
          }  
        } 
      });
      return false;
    });

    $(document).on("click", "button.is-favorite", function(){
      var id = $(this).attr('data-id');

      if($(this).hasClass("btn-danger")){
        fav = 1
      }
      if($(this).hasClass("btn-default")){
        fav = 0;
      }

      $.ajax({
        'url'      : '{{ url("seller/listings/change-favorite-status") }}/'+id+"/"+fav,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            // if(data.fav_status == 1){
            //   $(".is-favorite[data-id="+id+"]").removeClass("btn-danger").addClass("btn-default").text("Remove from favorites");
            // }
            // if(data.fav_status == 0){
            //   $(".is-favorite[data-id="+id+"]").removeClass("btn-default").addClass("btn-danger").text("Add to favorites");
            // }
            setTimeout(function(){ 
                location.reload();
            });
          }  
        } 
      });
      return false;
    });

    $(document).on("click", "button.button_delete", function(){
      var id = $(this).attr('data-id');

      swal({
        title: "Are you sure?",
        text: "This listing will be deleted permanently.",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
      },
      function(){
        $.ajax({
          'url'      : '{{ url("seller/listings/delete-listing") }}/'+id,
          'method'   : 'get',
          'dataType' : 'json',
          success    : function(data){
            if(data.status == 'success'){
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
      return false;
    });    
});
</script>
@stop