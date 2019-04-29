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
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Rate Your Experience</h3>
            </div>
            <div class="box-body">
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
    </section>
</div>
<div class="modal fade" id="post-rating" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Leave a Review</h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="rating-form">
          @csrf
          <input type="hidden" name="listing_id">
          <div class="form-group">
            <label>Your Rating</label>
            <div class="rating-row">
              <div class="rating-input">
                <input type="radio" name="rating" value="1">
                <label>1</label>
              </div>
              <div class="rating-input">
                <input type="radio" name="rating" value="2">
                <label>2</label>
              </div>
              <div class="rating-input">
                <input type="radio" name="rating" value="3">
                <label>3</label>
              </div>
              <div class="rating-input">
                <input type="radio" name="rating" value="4">
                <label>4</label>
              </div>
              <div class="rating-input">
                <input type="radio" name="rating" value="5">
                <label>5</label>
              </div>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Your Review</h4>
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