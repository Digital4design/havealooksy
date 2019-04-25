@extends('layouts.adminLayout.adminApp')

@section('pageCss')
  <style type="text/css">
    .filters{margin-bottom:20px;}
  </style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
          <div class="row">
            <div class="col-xs-12">
                <div class="box">
                <div class="box-header">
                  <h3 class="box-title">All Users</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="text-center filters">
                    <label style="margin-right:20px;">Filters : </label>
                    <button id="all" class="btn btn-primary">ALL</button>
                    <button id="active" class="btn btn-primary">ACTIVE</button>
                    <button id="blocked" class="btn btn-primary">BLOCKED</button>
                  </div>
                  <table id="user_list" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Postal Code</th>
                          <th>User Type</th>
                          <th>Status</th>
                          <th>Verification Status</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Postal Code</th>
                          <th>User Type</th>
                          <th>Status</th>
                          <th>Verification Status</th>
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
@endsection

@section('pageJs')
<script>
$(function() {
    var table = $('#user_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        ajax: {
          "url": '{!! url("admin/users/get-users") !!}',
          "type": 'GET',
          "data": function (data) {
                data.first_name = "{{ (!empty($first_name))? $first_name : null }}";
                data.last_name = "{{ (!empty($last_name))? $last_name : null }}";
                data.user_name = "{{ (!empty($user_name))? $user_name : null }}";
                data.email = "{{ (!empty($email))? $email : null }}";
                data.postal_code = "{{ (!empty($postal_code))? $postal_code : null }}";
                data.user_type = "{{ (!empty($user_type))? $user_type : null }}";
          }
        },
        columns: [
            { data: 'first_name', name: 'first_name', 
                render: function (data, type, row) {
                    return data +' '+ row.last_name;
                }, 
            },
            { data: 'last_name', name: 'last_name', visible: false },
            { data: 'user_name', name: 'user_name' },
            { data: 'email', name: 'email' },
            { data: 'postal_code', name: 'postal_code' },
            { data: 'user_type', name: 'user_type' },
            { data: 'status', name: 'status', orderable: false, visible: false },
            { data: 'email_verified_at', name: 'email_verified_at' },
            { data: 'action', name: 'action', orderable: false },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
        initComplete: function () {
          var filterColumns = [5, 7];

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

    $('#all').on('click', function () {
        table.columns(6).search("").draw();
    });

    $('#active').on('click', function () {
        table.columns(6).search("Active").draw();
    });

    $('#blocked').on('click', function () {
        table.columns(6).search("Blocked").draw();
    });

    $(document).on("click", "button", function(){
      var id = $(this).attr('data-id');

      if($(this).hasClass("btn-danger")){
        status_data = 0;
      }
      if($(this).hasClass("btn-info")){
        status_data = 1;
      }

      $.ajax({
        'url'      : '{{ url("admin/users/change-status") }}/'+id+"/"+status_data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            if(data.user_status == 1){
              $(".block-unblock[data-id="+id+"]").removeClass("btn-info").addClass("btn-danger").text("Block");
            }
            if(data.user_status == 0){
              $(".block-unblock[data-id="+id+"]").removeClass("btn-danger").addClass("btn-info").text("Unblock");
            }
          }  
        } 
      });
      return false;
    });
});
</script>
@stop