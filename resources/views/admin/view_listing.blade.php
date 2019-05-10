@extends('layouts.adminLayout.adminApp')

@section('pageCss')
@stop

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ $listing['title'] }}</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="breadcrumb-link">Looksy</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/listings') }}" class="breadcrumb-link">Listings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $listing['title'] }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body box">
                <div class="box-row">
                    <label>Title</label>
                    <p class="box-row-content">{{ $listing['title'] }}</p>
                </div>
                <div class="box-row">
                    <label>Description</label>
                    <p class="box-row-content">{{ $listing['description'] }}</p>
                </div>
                <div class="box-row">
                    <label>Location</label>
                    <p class="box-row-content">{{ $listing['location'] }}</p>
                </div>
                <div class="box-row">
                    <label>Price</label>
                    <p class="box-row-content">{{ $listing['price'] }}</p>
                </div>
                <div class="box-row">
                    <label>Category</label>
                    <p class="box-row-content">{{ $listing['getCategory']['name'] }}</p>
                </div>
                <div class="box-row">
                    <label>Status</label>
                    @if($listing['status'] == 1)
                    <p class="box-row-content">Active</p>
                    @elseif($listing['status'] == 0)
                    <p class="box-row-content">Inactive</p>
                    @endif
                </div>
                <div class="box-row">
                    <label>Images</label>
                    <p class="box-row-content" id="image-box">
                        @if(!$listing['getImages']->isEmpty())
                            @foreach($listing['getImages'] as $val)
                                <a href="{{ asset('public/images/listings/'.$val['name']) }}" data-lightbox="{{ $val['listing_id'] }}">
                                  <img src="{{ asset('public/images/listings/'.$val['name']) }}" style="height:80px;">
                                </a>
                            @endforeach
                        @else
                        -
                        @endif
                    </p>
                </div>
                <div class="box-row">
                    <label>People Allowed</label>
                    <p class="box-row-content">
                        @if(isset($listing['getGuests']['adults']))
                            {{ 'Adults' }}
                        @endif
                        @if(isset($listing['getGuests']['children']))
                            {{ ', Children' }}
                        @endif
                        @if(isset($listing['getGuests']['infants']))
                            {{ ', Infants' }}
                        @endif
                    </p>
                </div>
                <div class="box-row">
                    <label>People Count</label>
                    <p class="box-row-content">{{ $listing['getGuests']['total_count'] }}</p>
                </div>
                <div class="box-row">
                    <label>Time Slots</label>
                    <div class="box-row-content">
                        @foreach($listing['getTimes'] as $t)
                            <p>{{ Carbon::create($t['start_time'])->format("g:i a") }}-{{ Carbon::create($t['end_time'])->format("g:i a") }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="box-row">
                    <label></label>
                    <div class="box-row-content">
                        @if($listing['is_approved'] == 0)
                        <a href="#" data-id="{{ $listing['id'] }}" class="btn btn-danger approve-unapprove">Approve</a>
                        @elseif($listing['is_approved'] == 1)
                        <a href="#" data-id="{{ $listing['id'] }}" class="btn btn-light approve-unapprove">Unapprove</a>
                        @endif
                    </div>
                </div>
                @if($listing['deleted_at'])
                <div class="col-xs-12">
                    <div class="box-row-content" style="padding-left:30px;color:orange;">
                        <h5>* Deleted by {{ $deleting_user }} at {{ Carbon::create($listing['deleted_at']->toDateTimeString())->format("d/m/Y g:i a") }}</h5>
                    </div>
                </div>
                @endif
            </div>
          </div>
        </div> 
    </div>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", "a.approve-unapprove", function(){
          var id = $(this).attr('data-id');
          var that = this;

          if($(this).hasClass("btn-danger")){
            $(this).removeClass("btn-danger")
            newclass = "btn-light";
            message = "Approved";
            newlabel = "Unapprove";
            approval_data = 1;
          }
          if($(this).hasClass("btn-light")){
            $(this).removeClass("btn-light")
            newclass = "btn-danger";
            message = "Unapproved";
            newlabel = "Approve";
            approval_data = 0;
          }
          $("#loading").toggleClass("hide");
          $.ajax({
            'url'      : '{{ url("admin/listings/change-approval") }}/'+id+"/"+approval_data,
            'method'   : 'get',
            'dataType' : 'json',
            success    : function(data){
              if(data.status == 'success'){
                $(that).addClass(newclass);
                $(that).text(newlabel);
                $("#loading").toggleClass("hide");
                swal({
                    title: "Success",
                    text: "Listing has been "+message+"!",
                    timer: 2000,
                    type: "success",
                    showConfirmButton: false
                });
              }  
            } 
          });
          return false;
        });
    });
</script>
@stop