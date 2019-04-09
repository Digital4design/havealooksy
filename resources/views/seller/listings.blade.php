@extends('layouts.sellerLayout.sellerApp')

@section('pageCss')
<style type="text/css">
  #add-listing-button{margin:1em auto;font-size:20px;padding:0.3em 1.5em;}
  .filters{display:flex;justify-content:center;align-items:center;padding-bottom:20px;}
  .filters label{margin-right:30px;}
  .toolbar{float:left;height:35px;margin-top:5px;}
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
                  <div class="filters text-center">
                    <label>Filters:</label>
                    <button id="all" class="btn btn-primary" style="margin:auto 3px 0px;">ALL</button>
                    <div style="margin-right:50px;">
                      <button id="active" class="btn btn-primary">ACTIVE</button>
                      <button id="inactive" class="btn btn-primary">INACTIVE</button>
                    </div>
                    <div>
                      <button id="favorites" class="btn btn-danger">FAVORITES</button>
                    </div>
                  </div>
                  <table id="listings_list" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Location</th>
                          <th>Price</th>
                          <th>Category</th>
                          <th>Status</th>
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
                          <th>Status</th>
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
    var table = $('#listings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        dom: "<'row'<'col-md-2'l><'col-md-2 toolbar'><'col-md-8'Bf>>" + "<'row'<'col-md-4'><'col-md-4'>>" + "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
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
            { data: 'description', name: 'description', visible: false },
            { data: 'location', name: 'location' },
            { data: 'price', name: 'price' },
            { data: 'category', name: 'category' },
            { data: 'status', name: 'status', orderable: false, visible:false },
            { data: 'image', name: 'image', orderable: false },
            { data: 'activate_deactivate', name: 'activate_deactivate', orderable: false },
            { data: 'action', name: 'action', orderable: false },
            { data: 'is_favorite_listing', name: 'is_favorite_listing', orderable: false },
            { data: 'is_favorite', name: 'is_favorite', orderable: false, visible:false },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
    });

    $("div.toolbar").html('<a href class="description_hide_show" data-column="1"><span id="show-hide">Show</span> Description</a>');

    $("a.description_hide_show").on("click", function(e){
      e.preventDefault();
      var column = table.column($(this).attr('data-column'));
      column.visible(!column.visible());

      if($(this).text() == "Show Description"){
        $("#show-hide").text("Hide");
      }
      else if($(this).text() == "Hide Description"){
        $("#show-hide").text("Show");
      }
    });

    $('#all').on('click', function () {
        table.columns(5).search("").columns(10).search("").draw();
    });

    $('#active').on('click', function () {
        regExSearch = "^" + "Active" +"$";
        table.columns(5).search(regExSearch, true, false, false).draw();
    });

    $('#inactive').on('click', function () {
        table.columns(5).search("Deactive").draw();
    });

    $('#favorites').on('click', function () {
        regexEx = "^" + "Favorite" +"$";
        table.columns(10).search(regexEx, true, false, false).draw();
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
      $("#loading").toggleClass("hide");
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
            $("#loading").toggleClass("hide");
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
        text: "You want to delete this listing?",
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