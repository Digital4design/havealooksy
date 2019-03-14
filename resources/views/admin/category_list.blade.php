@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  #add-category-button{margin:1em auto;font-size:20px;padding:0.3em 1.5em;}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="pull-right">
                <button id="add-category-button" type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#add-category"><i class="fa fa-plus-circle"></i></button>
              </div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                <div class="box-header">
                  <h3 class="box-title">All Categories</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="category_list" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>Category Name</th>
                          <th>Status</th>
                          <th>Parent Category</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Category Name</th>
                          <th>Status</th>
                          <th>Parent Category</th>
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
<div class="modal fade" id="add-category" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="add_category_form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Add Category</h4>
        </div>
        <div class="modal-body">
          <
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
<script>
$(function() {
    $('#category_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        ajax: {
          "url": '{!! url("admin/get-categories") !!}',
          "type": 'GET',
          "data": function (data) {
                data.name = "{{ (!empty($name))? $name : null }}";
                data.status = "{{ (!empty($status)) ? $status : null }}";
                data.parent_category = "{{ (!empty($parent_id))? $parent_id : null }}";
          }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            { data: 'parent_category', name: 'parent_category' },
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

@section('pageJs')
<script type="text/javascript">
  $(document).ready(function(){
    $("#add_category_form").submit(function(){
      $.ajax({
        'url'      : '{{ url("/admin/add-category") }}',
        'method'   : 'post',
        'dataType' : 'json',
        'data'     : $(this).serialize(),
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
          else if(data.status == 'danger'){
            swal("Error", data.message, "warning");
          }
          else{
            console.log(data);

            $('.error').html('');
            $('.error').parent().removeClass('has-error');
            $.each(data,function(key,value){
              if(value != ""){
                $("#error-"+key).text(value);
                $("#error-"+key).parent().addClass('has-error');
              }
            });
          }  
        } 
      });
      return false;
    });
  });
</script>
@stop