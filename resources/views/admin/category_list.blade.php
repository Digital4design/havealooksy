@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  #add-category-button{margin:1em auto;font-size:20px;padding:0.3em 1.5em;}
  #add_category_form{padding:1em 2rem;}
  .error{color:red;}
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
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Category Name</th>
                          <th>Status</th>
                          <th>Parent Category</th>
                          <th>Action</th>
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
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Add Category</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" name="category_name" class="form-control" placeholder="Category Name">
            <p id="error-category_name" class="error"></p>
          </div>
          <div class="form-group">
            <select name="status" class="form-control">
              <option value="">Select Status</option>
              <option value="1">Active</option>
              <option value="0">Deactive</option>
            </select>
            <p id="error-status" class="error"></p>
          </div>
          <div id="parent_category" style="display:none;">
            <div class="form-group">
              <select name="parent_category" class="form-control">
                <option value="0">Select Parent Category</option>
              </select>
            </div>
          </div>
          <button id="attach_parent" type="button" class="btn btn-info"><span id="button_label">Attach Parent Category<i class="fa fa-plus" style="margin-left:0.5em;"></i></span></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
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
                data.parent_category = "{{ (!empty($parent_category))? $parent_category : null }}";
          }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            { data: 'parent_category', name: 'parent_category' },
            { data: 'action', name: 'action', orderable: false, },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
    });

    $("#add-category-button").on("click", function(){
      $.ajax({
        'url'      : '{{ url("admin/get-categories") }}',
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(response){
          $.each(response.data, function(key, value){
            $("select[name=parent_category]").append("<option value="+value['id']+">"+value['name']+"</option>");
          }); 
        } 
      });
    });

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

    $("#attach_parent").on("click", function(){
      $("#parent_category").toggle(500, function(){
        if ($(this).is(':visible')) 
        {
          $("#button_label").html("Remove<i class='fa fa-minus' style='margin-left:0.5em;'></i>");
        } 
        else 
        {
          $("#button_label").html("Attach Parent Category<i class='fa fa-plus' style='margin-left:0.5em;'></i>");
        }
      });
    });

    $("button.active-deactive").on("click", function(){
      var id = $(this).attr('data-id');
      var data = "";
      if($("button.active-deactive").hasClass("btn-danger")){
        data = '0';
      }
      if($("button.active-deactive").hasClass("btn-danger")){
        data = '1';
      }

      $.ajax({
        'url'      : '{{ url("/admin/change-status/'+id+'/'+data+'") }}',
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            if(data==0)
              $("button.active-deactive").removeClass("btn-danger").addClass("btn-default");
            if(data==1)
              $("button.active-deactive").removeClass("btn-default").addClass("btn-danger");
          }  
        } 
      });

    });    
});
</script>
@stop