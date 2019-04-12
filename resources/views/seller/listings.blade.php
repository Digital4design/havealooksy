@extends('layouts.sellerLayout.sellerApp')

@section('pageCss')
<style type="text/css">
  #add-listing-button{margin:1em auto;font-size:20px;padding:0.3em 1.5em;}
  .filters{display:flex;justify-content:center;align-items:center;padding-bottom:20px;}
  .filters label{margin-right:30px;}
  .toolbar{float:left;height:35px;margin-top:5px;}
  .btn.button_delete, .btn-info, .btn.active-deactive, .is-favorite{padding:6px 10px;}
  .btn.button_delete, .btn-info{display:inline;}
  .is-favorite{vertical-align:-webkit-baseline-middle;}
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
                          <th></th>
                          <th>Title</th>
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
                          <th></th>
                          <th>Title</th>
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
            {className: 'details-control', orderable: false, data: null, defaultContent: '' },
            { data: 'title', name: 'title' },
            // { data: 'description', name: 'description', visible: false },
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
                    } );
 
                column.data().unique().sort().each(function(d, j){
                    select.append('<option value="'+d+'">'+d+'</option>')
                });
            });
        },
    });

    function format(d){
      return '<table class="description_table">'+
                '<tr>'+
                    '<td><b>Description:<b></td>'+
                    '<td>'+d.description+'</td>'+
                '</tr>'+
              '</table>';
    }

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
        table.columns(5).search("").columns(10).search("").draw();
    });

    $('#active').on('click', function () {
        regExSearch = "^" + "Active" +"$";
        table.columns(5).search(regExSearch, true, false, false).columns(10).search("").draw();
    });

    $('#inactive').on('click', function () {
        table.columns(5).search("Deactive").columns(10).search("").draw();
    });

    $('#favorites').on('click', function () {
        regexEx = "^" + "Favorite" +"$";
        table.columns(10).search(regexEx, true, false, false).columns(5).search("").draw();
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

    $(document).on("click", "a.is-favorite", function(){
      var id = $(this).attr('data-id');
      var that = this;
      if($(this).find(".fa").hasClass("fa-star-o")){
        $(this).find(".fa").removeClass("fa-star-o");
        newclass = "fa-star";
        message = "added to";
        fav = 1;
      }
      else if($(this).find(".fa").hasClass("fa-star")){
        $(this).find(".fa").removeClass("fa-star");
        newclass = "fa-star-o";
        message = "removed from";
        fav = 0;
      }
      $("#loading").toggleClass("hide");
      $.ajax({
        'url'      : '{{ url("seller/listings/change-favorite-status") }}/'+id+"/"+fav,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            $(that).find(".fa").addClass(newclass);
            $("#loading").toggleClass("hide");
            swal({
                title: "Success",
                text: "Listing "+message+" Favorites!",
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