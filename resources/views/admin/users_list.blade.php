@extends('layouts.adminLayout.adminApp')
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
                  <table id="user_list" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Postal Code</th>
                          <th>User Type</th>
                          <th>Block/Unblock</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Postal Code</th>
                          <th>User Type</th>
                          <th>Block/Unblock</th>
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
    $('#user_list').DataTable({
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
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'user_name', name: 'user_name' },
            { data: 'email', name: 'email' },
            { data: 'postal_code', name: 'postal_code' },
            { data: 'user_type', name: 'user_type' },
            { data: 'block_unblock', name: 'block_unblock', orderable: false },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
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