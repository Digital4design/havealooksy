@extends('layouts.hostLayout.hostApp')

@section('pageCss')
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Add Listing</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('host/dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('host/listings') }}" class="breadcrumb-link">Listings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Listing</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
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
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" method="POST" action="{{ url('/host/listings/save-listing') }}" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="title" class="control-label">Title</label>
                      <input id="title" name="title" type="text" class="form-control" placeholder="Title" value="{{ $errors->has('title') ? old('title') : '' }}">

                      @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="description" class="control-label">Description</label>
                      <textarea id="description" name="description" class="form-control" placeholder="Description">{{ $errors->has('description') ? old('description') : '' }}</textarea>

                      @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="location" class="control-label">Location</label>
                      <input id="location" name="location" type="text" class="form-control" placeholder="Location" value="{{ $errors->has('location') ? old('location') : '' }}">

                      @if ($errors->has('location'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="price" class="control-label">Price</label>
                      <input id="price" name="price" type="text" class="form-control" placeholder="Price" value="{{ $errors->has('price') ? old('price') : '' }}">

                      @if ($errors->has('price'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="category" class="control-label">Category</label>
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
                  <div class="form-group">
                    <label for="status" class="control-label">Status</label>
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
                  <div class="form-group">
                    <label for="image" class="control-label">Images</label>
                      <input id="image" name="images[]" type="file" class="form-control" multiple>
                      <p class="help-block">You can select multiple files. Only .jpeg, .jpg, .png are supported.</p>

                      @if ($errors->has('images'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('images') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="people_allowed" class="control-label">People Allowed</label>
                      <div class="form_checkbox">
                        <input id="people_allowed" name="people_allowed[]" type="checkbox" value="Adults" checked required style="margin-top:3px;"><span class="checkbox-label">Adults</span>
                      </div>
                      <div class="form_checkbox">
                        <input id="people_allowed" name="people_allowed[]" type="checkbox" value="Children" style="margin-top:3px;"><span class="checkbox-label">Children</span>
                      </div>
                      <div class="form_checkbox">
                        <input id="people_allowed" name="people_allowed[]" type="checkbox" value="Infants" style="margin-top:3px;"><span class="checkbox-label">Infants</span>
                      </div>

                      @if ($errors->has('people_allowed'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('people_allowed') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="people_count" class="control-label">People Count<small style="display: block;color:#777;"> (Per Time Slot)</small></label>
                      <input id="people_count" name="people_count" type="number" class="form-control" placeholder="People Count" value="{{ $errors->has('people_count') ? old('people_count') : '' }}" min="0">

                      @if ($errors->has('people_count'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('people_count') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label class="control-label">Time Slot 1<small style="color:#777;"> (Per Day)</small></label>
                      <div style="display:flex;">
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0">
                        <label>Start Time</label>
                        <input type="text" name="start_time1" class="form-control timepicker" placeholder="0:00">
                        @if ($errors->has('start_time1'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('start_time1') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time1" class="form-control timepicker" placeholder="0:00">
                        @if ($errors->has('end_time1'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('end_time1') }}</strong>
                          </span>
                        @endif
                      </div>
                      </div>
                    </div>
                  </div>
                  <div id="second_time_slot" class="bootstrap-timepicker">
                    <div class="form-group">
                      <label class="control-label">Time Slot 2<small style="color:#777;"> (Per Day)</small></label>
                      <div style="display:flex;">
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0">
                        <label>Start Time</label>
                        <input type="text" name="start_time2" class="form-control timepicker" placeholder="0:00">
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time2" class="form-control timepicker" placeholder="0:00">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div id="third_time_slot" class="bootstrap-timepicker">
                    <div class="form-group">
                      <label class="control-label">Time Slot 3<small style="color:#777;"> (Per Day)</small></label>
                      <div style="display:flex;">
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0">
                        <label>Start Time</label>
                        <input type="text" name="start_time3" class="form-control timepicker" placeholder="0:00">
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time3" class="form-control timepicker" placeholder="0:00">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div id="fourth_time_slot" class="bootstrap-timepicker">
                    <div class="form-group">
                      <label class="control-label">Time Slot 4<small style="color:#777;"> (Per Day)</small></label>
                      <div style="display:flex;">
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0">
                        <label>Start Time</label>
                        <input type="text" name="start_time4" class="form-control timepicker" placeholder="0:00">
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time4" class="form-control timepicker" placeholder="0:00">
                      </div>
                      </div>
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
    </div>
</div>
@endsection

@section('pageJs')
@stop