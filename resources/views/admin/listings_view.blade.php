@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  #add-listing-button{margin-bottom:0.5em;font-size:20px;padding:0.2em 1.5em;}
  .filters{margin-bottom:10px;}
  .filters .btn{margin-bottom:10px;}
  .toolbar{float:left;height:35px;margin-top:5px;}
  .btn-info, .is-favorite, .btn.bg-secondary{padding:9px 10px;}
  .btn.button_delete{padding:6px 10px;}
  .btn.button_delete, .btn-info, .btn.bg-secondary{display:inline;}
  .approve-unapprove{vertical-align:-webkit-baseline-middle;}

  ::-webkit-input-placeholder{white-space:pre-line;position:relative;top:-7px;}
  ::-moz-placeholder{white-space:pre-line;position:relative;top:-7px;}
  :-ms-input-placeholder{white-space:pre-line;position:relative;top:-7px;}
  :-moz-placeholder{white-space:pre-line;position:relative;top:-7px;}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">All Listings</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Listings</li>
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
              <div class="text-center filters">
                <button id="all" class="btn btn-primary btn-sm">ALL</button>
                <button id="approved" class="btn btn-primary btn-sm">APPROVED</button>
                <button id="unapproved" class="btn btn-primary btn-sm">UNAPPROVED</button>
                <button id="founders_pick" class="btn btn-warning btn-sm" style="color:#fff;">FOUNDER PICKS</button>
                <button id="deleted" class="btn btn-danger btn-sm">DELETED LISTINGS</button>
              </div>
              <table id="listings_list" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th></th>
                      <th>Title</th>
                      <!-- <th>Description</th> -->
                      <th>Location</th>
                      <th>Price</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Images</th>
                      <th>Founder's Pick</th>
                      <th>Action</th>
                      <th>Approval</th>
                      <th>Approval Status</th>
                      <th></th>
                      <th>Created At</th>
                      <th>Deleted By</th>
                      <th>Deleted At</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th></th>
                      <th>Title</th>
                      <!-- <th>Description</th> -->
                      <th>Location</th>
                      <th>Price</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Images</th>
                      <th>Founder's Pick</th>
                      <th>Action</th>
                      <th>Approval</th>
                      <th>Approval Status</th>
                      <th></th>
                      <th>Created At</th>
                      <th>Deleted By</th>
                      <th>Deleted At</th>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div> 
    </div>
</div>
<div class="modal fade" id="image-modal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Images</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
<script>
  $(document).ready(function(){
    $('#listings_list tfoot th:eq(1),#listings_list tfoot th:eq(2),#listings_list tfoot th:eq(3),#listings_list tfoot th:eq(4),#listings_list tfoot th:eq(5)').each(function(){
        var title = $(this).text();
        $(this).css('width', '10%');
        $(this).html('<input type="text" class="form-control search-column" style="font-weight:normal;" placeholder="Search '+title+'" />');
    });     
    var table = $('#listings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        scrollX: true,
        order: [ 1, "asc" ],
        dom: "<'row'<'col-md-2'l><'col-md-2'B><'col-md-8'f>>" + "<'row'<'col-md-4'><'col-md-4'>>" + "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        buttons: [
          {
            extend: 'colvis',
            collectionLayout: 'fixed two-column',
            columns: [1, 2, 3, 4, 5, 13, 14]
          }
        ],
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
            {className: 'details-control', orderable: false, data: null, defaultContent: '' },
            { data: 'title', name: 'title' },
            // { data: 'description', name: 'description', visible: false },
            { data: 'location', name: 'location' },
            { data: 'price', name: 'price' },
            { data: 'category', name: 'category' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'images', name: 'images', orderable: false },
            { data: 'founder_pick_button', name: 'founder_pick_button', orderable: false },
            { data: 'action', name: 'action', orderable: false },
            { data: 'approved_unapproved', name: 'approved_unapproved', orderable: false },
            { data: 'is_approved', name: 'is_approved', orderable: false, visible: false },
            { data: 'founder_pick', name: 'founder_pick', orderable: false, visible: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'deleted_by', name: 'deleted_by', orderable: false, visible: false },
            { data: 'deleted_at', name: 'deleted_at', orderable: false, visible: false },
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

    function format(d){
      return '<table class="listing_details_table">'+
                '<tr>'+
                    '<td><b>Description:<b></td>'+
                    '<td>'+d.description+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td><b>Guests Allowed:<b></td>'+
                    '<td>'+d.guests+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td><b>Guests Count:<b></td>'+
                    '<td>'+d.guest_count+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td><b>Time Slots:<b></td>'+
                    '<td>'+d.time_slots+'</td>'+
                '</tr>'+
              '</table>';
    }

    $(document).on("click", "a.listing_images", function(){
      var id = $(this).attr("data-id");
      $("#image-modal .modal-body").html("");
      $.ajax({
        'url'      : '{{ url("admin/listings/get-images") }}/'+id,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            $("#image-modal .modal-body").html(data.images);
          }  
        } 
      });
      return false;
    });

    $('#listings_list tbody').on('click', 'td.details-control', function(){
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()){
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(format(row.data()) ).show();
            tr.addClass('shown');
        }
    });

    $('#all').on('click', function () {
        table.columns().search("").draw();
    });

    $('#approved').on('click', function () {
        regExSearch = "^" + "Approved" +"$";
        table.columns(10).search(regExSearch, true, false, false).columns(11).search("").columns(13).search("").draw();
    });

    $('#unapproved').on('click', function () {
        table.columns(10).search("Unapproved").columns(11).search("").columns(13).search("").draw();
    });

    $('#founders_pick').on('click', function () {
        table.columns(11).search("Yes").columns(10).search("").columns(13).search("").draw();
    });

    $('#deleted').on('click', function () {
        table.columns(13).search("You|Host", true, false).columns(10).search("").columns(11).search("").draw();
    });

    $(document).on("click", "a.founder_pick_btn", function(){
      var id = $(this).attr('data-id');
      var that = this;

      if($(this).hasClass("btn-danger")){
        $(this).removeClass("btn-danger");
        newclass = "btn-light";
        label = "Remove";
        new_data = 1;
      }
      if($(this).hasClass("btn-light")){
        $(this).removeClass("btn-light");
        newclass = "btn-danger";
        label = "Add";
        new_data = 0;
      }

      $("#loading").toggleClass("hide");
      $.ajax({
        'url'      : '{{ url("admin/listings/founder-pick") }}/'+id+"/"+new_data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            $(that).addClass(newclass);
            $(that).text(label);
            $("#loading").toggleClass("hide");
          }  
        } 
      });
      return false;
    });

    $(document).on("click", "a.remove_from_deleted", function(){
      var id = $(this).attr('data-id');

      swal({
        title: "Are you sure?",
        text: "You want to remove it from deleted listings?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        cancelButtonClass: "btn-light",
        confirmButtonText: "Yes!",
        closeOnConfirm: false
      },
      function(){
        $.ajax({
          'url'      : '{{ url("admin/listings/remove-from-deleted") }}/'+id,
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

    $(document).on("click", "a.approve-unapprove", function(){
      var id = $(this).attr('data-id');
      var that = this;

      if($(this).find(".far").hasClass("fa-circle")){
        $(this).find(".far").removeClass("text-danger fa-circle")
        newclass = "text-success fa-check-circle";
        message = "Approved";
        approval_data = 1;
      }
      if($(this).find(".far").hasClass("fa-check-circle")){
        $(this).find(".far").removeClass("text-success fa-check-circle")
        newclass = "text-danger fa-circle";
        message = "Unapproved";
        approval_data = 0;
      }
      $("#loading").toggleClass("hide");
      $.ajax({
        'url'      : '{{ url("admin/listings/change-approval") }}/'+id+"/"+approval_data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            $(that).find(".far").addClass(newclass);
            $("#loading").toggleClass("hide");
            swal({
                title: "Success",
                text: "Listing has been "+message+"!",
                timer: 2000,
                type: "success",
                showConfirmButton: false
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
        cancelButtonClass: "btn-light",
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