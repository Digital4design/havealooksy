@extends('layouts.hostLayout.hostApp')

@section('pageCss')
<style type="text/css">
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
              <h3 class="box-title">Bookings</h3>
            </div>
            <div class="box-body">
              <div class="col-xs-12 col-lg-6" id="booking_calendar"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

@section('pageJs')
<script type="text/javascript">
  $(document).ready(function(){
    $('#booking_calendar').fullCalendar({
          header : {left  : '', center: 'title', right : 'prev,next'},
          selectable: true,
    });
  });
</script>
@stop