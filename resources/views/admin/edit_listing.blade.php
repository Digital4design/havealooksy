@extends('layouts.adminLayout.adminApp')

@section('pageCss')
<style type="text/css">
  img{max-width: 100%;height: auto;}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ $listing_data['title'] }}</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/listings') }}" class="breadcrumb-link">Listings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $listing_data['title'] }}</li>
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
            <div class="card-body box">
                <form class="form-horizontal" method="POST" action="{{ url('/admin/listings/update-listing') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="listing_id" value="{{ $listing_data['id'] }}">
                <div class="box-body">
                  <div class="form-group">
                    <label for="title" class="control-label">Title</label>
                      <input id="title" name="title" type="text" class="form-control" placeholder="Title" value="{{ $errors->has('title') ? old('title') : $listing_data['title'] }}">

                      @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="description" class="control-label">Description</label>
                      <textarea id="description" name="description" class="form-control" placeholder="Description">{{ $errors->has('description') ? old('description') : $listing_data['description'] }}</textarea>

                      @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="location" class="control-label">Location</label>
                      <input id="location" name="location" type="text" class="form-control" placeholder="Location" value="{{ $errors->has('location') ? old('location') : $listing_data['location'] }}">

                      @if ($errors->has('location'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="price" class="control-label">Price</label>
                      <input id="price" name="price" type="text" class="form-control" placeholder="Price" value="{{ $errors->has('price') ? old('price') : $listing_data['price'] }}">

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
                  <div class="form-group" id="add_image_section">
                    <label for="image" class="control-label">Add Images</label>
                      <input id="image" name="images[]" type="file" class="form-control" multiple>
                      <p class="help-block">Only .jpeg, .jpg, .png are supported.</p>

                      @if ($errors->has('images'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('images') }}</strong>
                        </span>
                      @endif
                  </div>
                  @if(isset($listing_data['getImages'][0]))
                  <div class="form-group" id="uploaded_images">
                    <label for="image" class="control-label">Uploaded Images</label>
                      <div id="image-box">
                        @foreach($listing_data['getImages'] as $val)
                        <div class='edit_image_container'>
                          <a href="{{ asset('public/images/listings/'.$val['name']) }}" data-lightbox="{{ $val['listing_id'] }}">
                            <img src="{{ asset('public/images/listings/'.$val['name']) }}">
                          </a>
                          <a href="#" class="remove_image" data-id="{{ $val['id'] }}" style="display:block;">Remove</a>
                        </div>
                        @endforeach
                      </div>
                  </div>
                  @endif
                  <div class="form-group">
                    <label for="people_allowed" class="control-label">People Allowed</label>
                      <div class="form_checkbox">
                        <input id="people_allowed" name="people_allowed[]" type="checkbox" value="Adults" required {{ ($listing_data['getGuests']['adults']==1) ? 'checked':'' }} style="margin-top:3px;"><span class="checkbox-label">Adults</span>
                      </div>
                      <div class="form_checkbox">
                        <input id="people_allowed" name="people_allowed[]" type="checkbox" value="Children" {{ ($listing_data['getGuests']['children']==1) ? 'checked':'' }} style="margin-top:3px;"><span class="checkbox-label">Children</span>
                      </div>
                      <div class="form_checkbox">
                        <input id="people_allowed" name="people_allowed[]" type="checkbox" value="Infants" {{ ($listing_data['getGuests']['infants']==1) ? 'checked':'' }} style="margin-top:3px;"><span class="checkbox-label">Infants</span>
                      </div>

                      @if ($errors->has('people_allowed'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('people_allowed') }}</strong>
                        </span>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="people_count" class="control-label">People Count<small style="color:#777;"> (Per Time Slot)</small></label>
                      <input id="people_count" name="people_count" type="number" class="form-control" placeholder="People Count" value="{{ $errors->has('people_count') ? old('people_count') : $listing_data['getGuests']['total_count'] }}" min="0">

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
                        <input type="text" name="start_time1" class="form-control timepicker" value="{{ $listing_data['getTimes'][0]['start_time'] }}">
                        @if ($errors->has('start_time1'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('start_time1') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time1" class="form-control timepicker" value="{{ $listing_data['getTimes'][0]['end_time'] }}">
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
                        <input type="text" name="start_time2" class="form-control timepicker" value="{{ isset($listing_data['getTimes'][1]) ? $listing_data['getTimes'][1]['start_time'] : '' }}" placeholder="0:00">
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time2" class="form-control timepicker" value="{{ isset($listing_data['getTimes'][1]) ? $listing_data['getTimes'][1]['end_time'] : '' }}" placeholder="0:00">
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
                        <input type="text" name="start_time3" class="form-control timepicker" value="{{ isset($listing_data['getTimes'][2]) ? $listing_data['getTimes'][2]['start_time'] : '' }}" placeholder="0:00">
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time3" class="form-control timepicker" value="{{ isset($listing_data['getTimes'][2]) ? $listing_data['getTimes'][2]['end_time'] : '' }}" placeholder="0:00">
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
                        <input type="text" name="start_time4" class="form-control timepicker" value="{{ isset($listing_data['getTimes'][3]) ? $listing_data['getTimes'][3]['start_time'] : '' }}" placeholder="0:00">
                      </div>
                      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 px-0" style="margin-left:auto;">
                        <label>End Time</label>
                        <input type="text" name="end_time4" class="form-control timepicker" value="{{ isset($listing_data['getTimes'][3]) ? $listing_data['getTimes'][3]['end_time'] : '' }}" placeholder="0:00">
                      </div>
                      </div>
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
    </div>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
  $("a.remove_image").on("click", function(){
      var id = $(this).attr('data-id');
      $("#loading").toggleClass("hide");
      var that = this;

      $.ajax({
        'url'        : '{{ url("admin/listings/remove-listing-image") }}/'+id,
        'method'     : 'get',
        'dataType'   : 'json',
        success    : function(resp){
          
            if(resp.status == 'success'){
              $("#loading").toggleClass("hide");
              $(that).parent().css("display", "none");
              $(that).parent().remove();

              if($("#uploaded_images").find(".edit_image_container").length <= 0){
                $("#uploaded_images").css("display", "none");
              }

              swal({
                title: "Success",
                text: resp.message,
                timer: 1000,
                type: "success",
                showConfirmButton: false
              });
              // setTimeout(function(){ 
              //     location.reload();
              // }, 1000);
            }
            else if(resp.status == 'danger'){
              swal("Error", resp.message, "warning");
            }
        } 
      });
      return false;
  });
</script>
@stop