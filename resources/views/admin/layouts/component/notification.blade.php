@php
    $notifications = App\Models\OrderPlacedNotification::where('seen',0)->latest()->take(10)->get();
    $numberOfUnseenMessages = App\Models\Chat::where('receiver_id',auth()->user()->id)
    ->where('seen',0)->count();
@endphp

<li class="dropdown dropdown-list-toggle">
    <a href="{{ route('admin.chat.index') }}" data-toggle="dropdown" class="nav-link nav-link-lg message-envelope {{ $numberOfUnseenMessages > 0 ? 'beep' : '' }}" >
        <i class="far fa-envelope"></i>
    </a>

</li>

<li class="dropdown dropdown-list-toggle">
    <a href="#" data-toggle="dropdown"
       class="nav-link notification-toggle nav-link-lg notification_beep {{ count($notifications) > 0 ? 'beep' : '' }}">
        <i class="far fa-bell"></i>
    </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
            <div class="float-right">
                <a href="{{ route('admin.clear-notification') }}">Mark All As Read</a>
            </div>
        </div>

        {{--        Notification if new order is placed--}}
        <div class="dropdown-list-content dropdown-list-icons rt_notification">
            @foreach($notifications as $notification)
                <a href="{{route('admin.orders.show', $notification->order_id/**/)}}"
                   class="dropdown-item dropdown-item-unread">
                    <div class="dropdown-item-icon bg-primary text-white">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="dropdown-item-desc">
                        {{$notification->message}}
                        <div
                            class="time text-primary">{{ date('h:i A | d-F-Y', strtotime($notification->created_at)) }}</div>
                    </div>
                </a>
            @endforeach

        </div>
        <div class="dropdown-footer text-center">
            <a href="{{ route('admin.orders.index') }}">View All <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</li>
