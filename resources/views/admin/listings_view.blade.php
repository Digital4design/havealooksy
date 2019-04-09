@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  .box{border:none;}
  .toolbar{float:left;height:35px;margin-top:5px;}
  .filters{margin-bottom:20px;}
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
                  <h3 class="box-title">All Listings</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="text-center filters">
                    <button id="all" class="btn btn-primary">ALL</button>
                    <button id="approved" class="btn btn-primary">APPROVED</button>
                    <button id="unapproved" class="btn btn-primary">UNAPPROVED</button>
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
                          <th>Approve/Unapprove</th>
                          <th>Action</th>
                          <th>Approval Status</th>
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
                          <th>Approve/Unapprove</th>
                          <th>Action</th>
                          <th>Approval Status</th>
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
    var table = $('#listings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        dom: "<'row'<'col-md-2'l><'col-md-2 toolbar'><'col-md-8'Bf>>" + "<'row'<'col-md-4'><'col-md-4'>>" + "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        ajax: {
          "url": '{!! url("admin/listings/get-listings") !!}',
          "type": 'GET',
          "data": function (data) {
                data.title = "{{ (!empty($title))? $title : null }}";
                data.description = "{{ (!empty($description))? $description : null }}";
                data.location = "{{ (!empty($location)) ? $location : null }}";
                data.price = "{{ (!empty($price))? $price : null }}";
                data.category = "{{ (!empty($category))? $category : null }}";
          }
        },
        columns: [
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description', visible: false },
            { data: 'location', name: 'location' },
            { data: 'price', name: 'price' },
            { data: 'category', name: 'category' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'image', name: 'image', orderable: false },
            { data: 'approved_unapproved', name: 'approved_unapproved', orderable: false },
            { data: 'action', name: 'action', orderable: false },
            { data: 'is_approved', name: 'is_approved', orderable: false, visible: false },
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
        table.columns(9).search("").draw();
    });

    $('#approved').on('click', function () {
        regExSearch = "^" + "Approved" +"$";
        table.columns(9).search(regExSearch, true, false, false).draw();
    });

    $('#unapproved').on('click', function () {
        table.columns(9).search("Unapproved").draw();
    });

    $(document).on("click", "button.approve-unapprove", function(){
      var id = $(this).attr('data-id');

      if($(this).hasClass("btn-danger")){
        approval_data = 1;
      }
      if($(this).hasClass("btn-default")){
        approval_data = 0;
      }

      $.ajax({
        'url'      : '{{ url("admin/listings/change-approval") }}/'+id+"/"+approval_data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            if(data.listing_approval_status == 1){
              $(".approve-unapprove[data-id="+id+"]").removeClass("btn-danger").addClass("btn-default").text("Unapprove");
            }
            if(data.listing_approval_status == 0){
              $(".approve-unapprove[data-id="+id+"]").removeClass("btn-default").addClass("btn-danger").text("Approve");
            }
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
          'url'      : '{{ url("admin/listings/delete-listing") }}/'+id,
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