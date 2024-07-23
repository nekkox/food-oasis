<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                             class="nav-link nav-link-lg message-toggle beep"><i
            class="far fa-envelope"></i></a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Messages
            <div class="float-right">
                <a href="#">Mark All As Read</a>
            </div>
        </div>
        <div class="dropdown-list-content dropdown-list-message">
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-avatar">
                    <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle">
                    <div class="is-online"></div>
                </div>
                <div class="dropdown-item-desc">
                    <b>Kusnaedi</b>
                    <p>Hello, Bro!</p>
                    <div class="time">10 Hours Ago</div>
                </div>
            </a>

        </div>
        <div class="dropdown-footer text-center">
            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</li>

@php

    $notifications = App\Models\OrderPlacedNotification::where('seen',0)->latest()->take(10)->get();

@endphp

<li class="dropdown dropdown-list-toggle">
    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
        <i class="far fa-bell"></i>
    </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
            <div class="float-right">
                <a href="#">Mark All As Read</a>
            </div>
        </div>

        <div class="dropdown-list-content dropdown-list-icons rt_notification">
            @foreach($notifications as $notification)
                <a href="{{route('admin.orders.show', $notification->order_id/**/)}}"
                   class="dropdown-item dropdown-item-unread">
                    <div class="dropdown-item-icon bg-primary text-white">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="dropdown-item-desc">
                        {{$notification->message}}
                        <div class="time text-primary">2 Min Ago</div>
                    </div>
                </a>
            @endforeach

        </div>
        <div class="dropdown-footer text-center">
            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</li>
