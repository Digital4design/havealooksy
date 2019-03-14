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
          "url": '{!! url("admin/get-users") !!}',
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