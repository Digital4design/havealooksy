@extends('layouts.sellerLayout.sellerApp')

@section('pageCss')
<style type="text/css">
  img{max-width: 100%;height: auto;}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Listing</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('/seller/listings/update-listing') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="listing_id" value="{{ $listing_data['id'] }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                    <input id="title" name="title" type="text" class="form-control" placeholder="Title" value="{{ $errors->has('title') ? old('title') : $listing_data['title'] }}">

                    @if ($errors->has('title'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('title') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-10">
                    <textarea id="description" name="description" class="form-control" placeholder="Description">{{ $errors->has('description') ? old('description') : $listing_data['description'] }}</textarea>

                    @if ($errors->has('description'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('description') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="location" class="col-sm-2 control-label">Location</label>
                  <div class="col-sm-10">
                    <input id="location" name="location" type="text" class="form-control" placeholder="Location" value="{{ $errors->has('location') ? old('location') : $listing_data['location'] }}">

                    @if ($errors->has('location'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('location') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="price" class="col-sm-2 control-label">Price</label>
                  <div class="col-sm-10">
                    <input id="price" name="price" type="text" class="form-control" placeholder="Price" value="{{ $errors->has('price') ? old('price') : $listing_data['price'] }}">

                    @if ($errors->has('price'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('price') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="category" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-10">
                    <select id="category" name="category" class="form-control">
                      <option value="">Select Category</option>
                      @foreach($categories as $value)
                        <option value="{{$value['id']}}" {{ ($listing_data['category_id']==$value['id']) ? 'selected':'' }}>{{ $value['name'] }}</option>
                        @if(!$value['childCategories']->isEmpty())
                          @foreach($value['childCategories'] as $cc)
                            <option value="{{$cc['id']}}" {{ ($listing_data['category_id']==$cc['id']) ? 'selected':'' }}>&nbsp;&nbsp;- {{$cc['name']}}</option>
                          @endforeach
                        @endif
                      @endforeach
                    </select>

                    @if ($errors->has('category'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('category') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="status" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                    <select id="status" name="status" class="form-control">
                      <option value="">Select Status</option>
                      <option value="1" {{ ($listing_data['status']==1) ? 'selected':'' }}>Active</option>
                      <option value="0" {{ ($listing_data['status']==0) ? 'selected':'' }}>Deactive</option>
                    </select>

                    @if ($errors->has('status'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('status') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
                <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-3">
                    <img id="listing_image" src="{{ asset('public/images/listings/'.$listing_data['image']) }}">
                    <a id="remove_image" style="margin-top: 10px;" class="btn btn-block btn-info">Remove</a>
                  </div>
                </div>
                <div class="form-group" id="add_image_section" style="display: none;">
                  <label for="image" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-10">
                    <input id="image" name="image" type="file" class="form-control">
                    <p class="help-block">Only .jpeg, .jpg, .png are supported.</p>

                    @if ($errors->has('image'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('image') }}</strong>
                      </span>
                    @endif

                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
  $("a#remove_image").on("click", function(){
    $(this).parent().closest("div").fadeOut(200, function(){
      $(this).parent().closest("div").remove();
    });
    $("#add_image_section").fadeIn(100, function(){
      $("#add_image_section").css("display", "block");
    });
  });
</script>
@stop