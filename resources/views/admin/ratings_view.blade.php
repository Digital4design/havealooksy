@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  .filters .btn{margin-bottom:10px;}
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
                  <h3 class="box-title">All Ratings & Reviews</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="text-center filters">
                    <button id="all" class="btn btn-primary">ALL</button>
                    <button id="approved" class="btn btn-primary">APPROVED</button>
                    <button id="discarded" class="btn btn-danger">DISCARDED</button>
                    <button id="spam" class="btn btn-warning">SPAM</button>
                  </div>
                  <table id="ratings_list" class="table table-bordered table-striped" style="width:100%;">
                    <thead>
                        <tr>
                          <th>Listing</th>
                          <th>Rating</th>
                          <th>Review</th>
                          <th>Posted By</th>
                          <th>Status</th>
                          <th>Spam</th>
                          <th>Approval Status</th><!--  For Filtering purpose only  -->
                          <th>Spam Status</th><!--  For Filtering purpose only  -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Listing</th>
                          <th>Rating</th>
                          <th>Review</th>
                          <th>Posted By</th>
                          <th>Approval Status</th><!--  For Filtering purpose only  -->
                          <th>Spam Status</th><!--  For Filtering purpose only  -->
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
    $('#ratings_list tfoot th:eq(0),#ratings_list tfoot th:eq(1),#ratings_list tfoot th:eq(2),#ratings_list tfoot th:eq(3)').each(function(){
        var title = $(this).text();
        $(this).css('width', '10%');
        $(this).html('<input type="text" class="form-control search-column" style="font-weight:normal;" placeholder="Search '+title+'" />');
    });     
    var table = $('#ratings_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        scrollX: true,
        ajax: {
          "url": '{!! url("admin/ratings/get-ratings") !!}',
          "type": 'GET',
        },
        columns: [
            { data: 'listing_id', name: 'listing_id' },
            { data: 'rating', name: 'rating' },
            { data: 'review', name: 'review', width: '40%' },
            { data: 'posted_by', name: 'posted_by' },
            { data: 'approved', name: 'approved' },
            { data: 'spam', name: 'spam' },
            { data: 'approval_status', name: 'approval_status', visible: false },
            { data: 'spam_status', name: 'spam_status', visible: false },
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

    $('#all').on('click', function () {
        table.columns().search("").draw();
    });

    $('#approved').on('click', function () {
        table.columns(6).search("Approved").columns(7).search("").draw();
    });

    $('#discarded').on('click', function () {
        table.columns(6).search("Discarded").columns(7).search("").draw();
    });

    $('#spam').on('click', function () {
        table.columns(7).search("Yes").columns(6).search("").draw();
    });

    $(document).on("click", "a.approval", function(){
      var id = $(this).attr('data-id');

      if($(this).hasClass("btn-info"))
      {
        $(this).removeClass("btn-info").addClass("btn-default");
        $(this).text("Discard");
        approval_data = 1;
        message = "Approved";
      }
      else if($(this).hasClass("btn-default"))
      {
        $(this).removeClass("btn-default").addClass("btn-info");
        $(this).text("Approve");
        approval_data = 0;
        message = "Discarded";
      }

      $("#loading").toggleClass("hide");
      $.ajax({
        'url'      : '{{ url("admin/ratings/change-approval") }}/'+id+"/"+approval_data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            
            $("#loading").toggleClass("hide");
            swal({
                title: "Success",
                text: "Review has been "+message+"!",
                timer: 2000,
                type: "success",
                showConfirmButton: false
            });
          }  
        } 
      });
      return false;
    });

    $(document).on("click", "a.spam", function(){
      var id = $(this).attr('data-id');

      if($(this).hasClass("btn-danger"))
      {
        $(this).removeClass("btn-danger").addClass("btn-default");
        $(this).text("Remove from Spam");
        data = 1;
        message = "Marked as Spam";
      }
      else if($(this).hasClass("btn-default"))
      {
        $(this).removeClass("btn-default").addClass("btn-danger");
        $(this).text("Mark as Spam");
        data = 0;
        message = "Removed from Spam";
      }

      $("#loading").toggleClass("hide");
      $.ajax({
        'url'      : '{{ url("admin/ratings/mark-spam") }}/'+id+"/"+data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            
            $("#loading").toggleClass("hide");
            swal({
                title: "Success",
                text: "Review has been "+message+"!",
                timer: 2000,
                type: "success",
                showConfirmButton: false
            });
          }  
        } 
      });
      return false;
    });
  });
</script>
@stop