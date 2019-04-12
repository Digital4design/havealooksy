@foreach($conversations as $val)
  @if($val['unread'] != 0)
    <li style="background-color:#d6f5f5;box-shadow:1px 1px 5px #ccc;">
      <a href="{{ url('admin/chat/get-chat/'.$val['user']['id']) }}">
        <div class="pull-left">
          <img src="{{ $val['user']['profile_picture'] ? asset('public/images/profile_pictures/'.$val['user']['profile_picture']) : asset('public/images/default-pic.png')}}" class="img-circle" style="border:2px solid #ccc;">
        </div>
        <h4>
          {{ $val['user']['first_name'] }} {{ $val['user']['last_name'] }}
          <div class="pull-right">
            <i class="fa fa-circle" style="color:orange;font-size:20px;position:relative;"><span style="font-size:12px;color:#fff;position:absolute;left:3px;top:4px;">&nbsp;{{ $val['unread'] }}</span></i>
          </div>
        </h4>
        <p style="margin-bottom:0px;color:#999;font-size:12px;">{{ $val['last_message']['body'] }}</p>
      </a>
    </li>
  @endif
@endforeach