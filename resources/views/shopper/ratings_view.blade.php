@extends('layouts.shopperLayout.shopperApp')

@section('pageCss')
<style type="text/css">
  .form-group, .rating-input{display:flex;flex-direction:column;}
  .rating-row{display:flex;}
  .rating-row i{color:orange;margin-right:10px;}
  .rating-input{padding-right:40px;}
  a.show-review{text-decoration:none;color:#666;padding-left:15px;}
  a.show-review:hover{text-decoration:none;color:#444;padding-left:15px;}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
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
            <div class="page-header">
                <h2 class="pageheader-title">Rate Your Experience</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Rate Your Experience</li>
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
              <table id="products-ratings" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>Product</th>
                      <th>Location</th>
                      <th>Price</th>
                      <th>Booking Date</th>                      
                      <th>Details</th>            
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Product</th>
                      <th>Location</th>
                      <th>Price</th>
                      <th>Booking Date</th>
                      <th>Details</th>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div> 
    </div>
</div>
<div class="modal fade" id="post-rating" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Leave a Review</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="rating-form">
          @csrf
          <input type="hidden" name="listing_id">
          <div class="form-group">
            <label>Your Rating</label>
            <div class="rating-row">
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" name="rating" class="custom-control-input" value="1"><span class="custom-control-label">1</span>
              </label>
              <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="rating" class="custom-control-input" value="2"><span class="custom-control-label">2</span>
              </label>
              <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="rating" class="custom-control-input" value="3"><span class="custom-control-label">3</span>
              </label>
              <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="rating" class="custom-control-input" value="4"><span class="custom-control-label">4</span>
              </label>
              <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="rating" class="custom-control-input" value="5"><span class="custom-control-label">5</span>
              </label>
            </div>
            <p class="error" id="error-rating"></p>
          </div>
          <div class="form-group">
            <label>Comment</label>
            <textarea name="review" class="form-control" rows="3" placeholder="Write your review here..."></textarea>
            <p class="error" id="error-review"></p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary pull-right" form="rating-form">Submit</button>
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="show-rating" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Your Review</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body" id="review-body" style="font-size:15px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#products-ratings').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [10,25,50,100],
        responsive: true,
        order: [ 1, "asc" ],
        ajax: {
          "url": '{!! url("shopper/ratings/get-products-ratings") !!}',
          "type": 'GET',
        },
        columns: [
            { data: 'product', name: 'product' },
            { data: 'location', name: 'location' },
            { data: 'price', name: 'price' },
            { data: 'date', name: 'date' },
            { data: 'rating', name: 'rating' },
        ],
        oLanguage: {
          "sInfoEmpty" : "Showing 0 to 0 of 0 entries",
          "sZeroRecords": "No matching records found",
          "sEmptyTable": "No data available in table",
        },
    });

    $(document).on("click", "a.post-rating", function(){
      $("input[name=listing_id]").val($(this).attr("data-id"));
    });

    $("#rating-form").submit(function(){
      $.ajax({
          'url'        : '{{ url("shopper/ratings/post-review") }}',
          'method'     : 'post',
          'data'       : $(this).serialize(),
          'dataType'   : 'json',
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
                // $('.error').parent().removeClass('has-error');
                $.each(data,function(key,value){
                  if(value != ""){
                      $("#error-"+key).text(value);
                      // $("#error-"+key).parent().addClass('has-error');
                  }
                });
              }
          } 
      });
      return false;
    });

    $(document).on("click", "a.show-review", function(){
      var id = $(this).attr("data-id");
      $.ajax({
          'url'        : '{{ url("shopper/ratings/get-review") }}/'+id,
          'method'     : 'get',
          'dataType'   : 'json',
          success    : function(data){
            
              if(data.status == 'success'){
                $("#review-body").html(data.result);
              }
              else if(data.status == 'danger'){
                swal("Error", data.message, "warning");
              }
          } 
      });
      return false;
    });
  });
</script>
@stop