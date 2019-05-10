@extends('layouts.adminLayout.adminApp')

@section('pageCss')
  <style type="text/css">
    .filters{margin-bottom:20px;}
    .btn-info, .btn-danger, .btn-success{display:inline;}
    .btn-danger, .btn-success{padding:5.5px 12px;}

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
                <h2 class="pageheader-title">All Users</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
              <div class="text-center filters">
                <button id="all" class="btn btn-primary btn-sm">ALL</button>
                <button id="active" class="btn btn-primary btn-sm">ACTIVE</button>
                <button id="blocked" class="btn btn-primary btn-sm">BLOCKED</button>
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
                      <th></th>
                      <th>Status</th><!-- Verification -->
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
                      <th></th>
                      <th>Status</th><!-- Verification -->
                      <th>Action</th>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div> 
    </div>
</div>
@endsection

@section('pageJs')
<script>
$(function() {
    $('#user_list tfoot th:eq(0),#user_list tfoot th:eq(1),#user_list tfoot th:eq(2),#user_list tfoot th:eq(3),#user_list tfoot th:eq(4),#user_list tfoot th:eq(5),#user_list tfoot th:eq(6),#user_list tfoot th:eq(7)').each(function(){
        var title = $(this).text();
        $(this).css('width', '10%');
        $(this).html('<input type="text" class="form-control search-column" style="font-weight:normal;" placeholder="Search '+title+'" />');
    });
    var table = $('#user_list').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        scrollX: true,
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
      if($(this).hasClass("btn-success")){
        status_data = 1;
      }

      $.ajax({
        'url'      : '{{ url("admin/users/change-status") }}/'+id+"/"+status_data,
        'method'   : 'get',
        'dataType' : 'json',
        success    : function(data){
          if(data.status == 'success'){
            if(data.user_status == 1){
              $(".block-unblock[data-id="+id+"]").removeClass("btn-success").addClass("btn-danger").text("Block");
            }
            if(data.user_status == 0){
              $(".block-unblock[data-id="+id+"]").removeClass("btn-danger").addClass("btn-success").text("Unblock");
            }
          }  
        } 
      });
      return false;
    });
});
</script>
@stop