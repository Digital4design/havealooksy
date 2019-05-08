@if($unread != 0)
<div class="notification-list">
  <div class="list-group">
      @foreach($conversations as $val)
        @if($val['unread'] != 0)
        <a href="{{ url('shopper/chat/get-chat/'.$val['user']['id']) }}" class="list-group-item list-group-item-action active">
            <div class="notification-info">
                <div class="notification-list-user-img"><img src="{{ $val['user']['profile_picture'] ? asset('public/images/profile_pictures/'.$val['user']['profile_picture']) : asset('public/images/default-pic.png')}}" alt="User" class="user-avatar-md rounded-circle"></div>
                <div class="notification-list-user-block">
                  <span class="notification-list-user-name">{{ $val['user']['first_name'] }} {{ $val['user']['last_name'] }}</span>
                  <div>
                    {{ $val['last_message']['body'] }}
                  </div>
                </div>
            </div>
        </a>
        @endif
      @endforeach
  </div>
</div>
@endif