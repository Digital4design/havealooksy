@extends('layouts.hostLayout.hostApp')
@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Listing</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('/host/listings/save-listing') }}" enctype="multipart/form-data">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                    <input id="title" name="title" type="text" class="form-control" placeholder="Title" value="{{ $errors->has('title') ? old('title') : '' }}">

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
                    <textarea id="description" name="description" class="form-control" placeholder="Description">{{ $errors->has('description') ? old('description') : '' }}</textarea>

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
                    <input id="location" name="location" type="text" class="form-control" placeholder="Location" value="{{ $errors->has('location') ? old('location') : '' }}">

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
                    <input id="price" name="price" type="text" class="form-control" placeholder="Price" value="{{ $errors->has('price') ? old('price') : '' }}">

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
                        <option value="{{$value['id']}}">{{ $value['name'] }}</option>
                        @if(!$value['childCategories']->isEmpty())
                          @foreach($value['childCategories'] as $cc)
                            <option value="{{$cc['id']}}">&nbsp;&nbsp;- {{$cc['name']}}</option>
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
                      <option value="1">Active</option>
                      <option value="0">Deactive</option>
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
                <button type="submit" class="btn btn-primary pull-right">Add Listing</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection