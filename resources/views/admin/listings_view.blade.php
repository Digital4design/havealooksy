@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  .box{border:none;}
  .toolbar{float:left;height:35px;margin-top:5px;}
  .filters{margin-bottom:20px;}
  .btn.button_delete, .btn-info, .btn.bg-teal{display:inline;}
  .approve-unapprove{vertical-align:-webkit-baseline-middle;}
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
                    <button id="founders_pick" class="btn btn-danger">FOUNDER PICKS</button>
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
                          <th></th>
                          <th>Approval Status</th>
                          <th></th>
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
                          <th></th>
                          <th>Approval Status</th>
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
<div class="modal fade" id="image-modal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Images</h4>
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
    var table = $('#listings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        order: [ 1, "asc" ],
        dom: "<'row'<'col-md-2'l><'col-md-2'B><'col-md-8'f>>" + "<'row'<'col-md-4'><'col-md-4'>>" + "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        buttons: [
          {
            extend: 'colvis',
            collectionLayout: 'fixed two-column',
            columns: [1, 2, 3, 4, 5]
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
            { data: 'status', name: 'status', orderable: false, visible: false },
            { data: 'images', name: 'images', orderable: false },
            { data: 'founder_pick_button', name: 'founder_pick_button', orderable: false },
            { data: 'action', name: 'action', orderable: false },
            { data: 'approved_unapproved', name: 'approved_unapproved', orderable: false },
            { data: 'is_approved', name: 'is_approved', orderable: false, visible: false },
            { data: 'founder_pick', name: 'founder_pick', orderable: false, visible: false },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
        initComplete: function () {
          var filterColumns = [1, 2, 3, 4, 5];

          this.api().columns(filterColumns).every(function(){
                var column = this;
                var select = $('<select class="form-control" style="font-weight:normal;"><option value="">Select</option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function(){
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        val = String(val).replace(/&/g, '&amp;');
 
                        column.search(val ? '^'+val+'$' : '', true, false, false).draw();
                    });
 
                column.data().unique().sort().each(function(d, j){
                    select.append('<option value="'+d+'">'+d+'</option>')
                });
            });
        },
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
        table.columns(10).search("").columns(11).search("").draw();
    });

    $('#approved').on('click', function () {
        regExSearch = "^" + "Approved" +"$";
        table.columns(10).search(regExSearch, true, false, false).columns(11).search("").draw();
    });

    $('#unapproved').on('click', function () {
        table.columns(10).search("Unapproved").columns(11).search("").draw();
    });

    $('#founders_pick').on('click', function () {
        table.columns(11).search("Yes").columns(10).search("").draw();
    });

    $(document).on("click", "a.founder_pick_btn", function(){
      var id = $(this).attr('data-id');
      var that = this;

      if($(this).hasClass("bg-olive")){
        $(this).removeClass("bg-olive");
        newclass = "btn-default";
        label = "Remove";
        new_data = 1;
      }
      if($(this).hasClass("btn-default")){
        $(this).removeClass("btn-default");
        newclass = "bg-olive";
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

    $(document).on("click", "a.approve-unapprove", function(){
      var id = $(this).attr('data-id');
      var that = this;

      if($(this).find(".fa").hasClass("fa-square-o")){
        $(this).find(".fa").removeClass("text-red fa-square-o")
        newclass = "text-green fa-check-square-o";
        message = "Approved";
        approval_data = 1;
      }
      if($(this).find(".fa").hasClass("fa-check-square-o")){
        $(this).find(".fa").removeClass("text-green fa-check-square-o")
        newclass = "text-red fa-square-o";
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
            $(that).find(".fa").addClass(newclass);
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