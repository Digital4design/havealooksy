<div id="image-box">
  @foreach($get_images as $val)
    <a class='image_container' href="{{ asset('public/images/listings/'.$val['name']) }}" data-lightbox="{{ $val['listing_id'] }}">
      <img src="{{ asset('public/images/listings/'.$val['name']) }}">
    </a>
  @endforeach
</div>