<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">
        @include('admin.layouts.component.notification')
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{asset(auth()->user()->avatar)}}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{auth()->user()->name}}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{route('admin.profile')}}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>


                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#" onclick="event.preventDefault();
                        this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>


            </div>
        </li>
    </ul>
</nav>


{{--LEFT SIDEBAR--}}
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('admin.dashboard')}}">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('admin.dashboard')}}">St</a>

        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li class="{{ setSidebarActive(['admin.dashboard']) }}"><a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fas fa-fire"></i>
                    Dashboard</a>
            </li>

            <li class="menu-header">Starter</li>

            <li class= {{ setSidebarActive(['admin.slider.*']) }} ><a class="nav-link " href="{{route('admin.slider.index')}}"><i class="fas fa-images"></i>
                    <span>Slider</span></a></li>


            <li class="dropdown {{ setSidebarActive([
                'admin.orders.index',
                'admin.pending-orders',
                'admin.inprocess-orders',
                'admin.delivered-orders',
                'admin.declined-orders'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i>
                    <span>Orders </span></a>
                <ul class="dropdown-menu">
                    <li class= {{ setSidebarActive(['admin.orders.index']) }} ><a class="nav-link" href="{{ route('admin.orders.index') }}">All Orders</a></li>
                    <li class= {{ setSidebarActive(['admin.pending-orders']) }}><a class="nav-link" href="{{ route('admin.pending-orders') }}">Pending Orders</a></li>
                    <li class= {{ setSidebarActive(['admin.inprocess-orders']) }}><a class="nav-link" href="{{ route('admin.inprocess-orders') }}">In Process Orders</a></li>
                    <li class= {{ setSidebarActive(['admin.delivered-orders']) }}><a class="nav-link" href="{{ route('admin.delivered-orders') }}">Delivered Orders</a></li>
                    <li class= {{ setSidebarActive(['admin.declined-orders']) }}><a class="nav-link" href="{{ route('admin.declined-orders') }}">Declined Orders</a></li>
                </ul>
            </li>

            <li class="dropdown {{setSidebarActive([
                'admin.category.index',
                'admin.product.index',
                'admin.product-reviews.index'
            ])}} ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i> <span>Manage Products</span></a>
                <ul class="dropdown-menu">
                    <li class= {{ setSidebarActive(['admin.category.index']) }}><a class="nav-link" href="{{route('admin.category.index')}}">Product Categories</a></li>
                    <li class= {{ setSidebarActive(['admin.product.index']) }}><a class="nav-link" href="{{route('admin.product.index')}}">Products</a></li>
                    <li class= {{ setSidebarActive(['admin.product-reviews.index']) }}><a class="nav-link" href="{{ route('admin.product-reviews.index') }}">Product Reviews</a></li>
                </ul>
            </li>


            <li class="dropdown {{
                setSidebarActive([
                    'admin.coupon.index',
                    'admin.delivery-area.index',
                    'admin.payment-setting.index'
                ])
            }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i> <span>Manage Ecommerce</span></a>
                <ul class="dropdown-menu">
                    <li class= {{ setSidebarActive(['admin.coupon.index']) }}><a class="nav-link" href="{{route('admin.coupon.index')}}">Coupon</a></li>
                    <li class= {{ setSidebarActive(['admin.delivery-area.index']) }}><a class="nav-link" href="{{ route('admin.delivery-area.index') }}">Delivery Areas</a></li>
                    <li class= {{ setSidebarActive(['admin.payment-setting.index']) }}><a class="nav-link" href="{{ route('admin.payment-setting.index') }}">Payment Gateways</a></li>
                </ul>
            </li>

            <li class="dropdown {{
                setSidebarActive([
                    'admin.reservation-time.index',
                    'admin.reservation.index',
                ])
            }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-chair"></i>
                    <span>Manage Reservations </span></a>
                <ul class="dropdown-menu">
                    <li class= {{ setSidebarActive(['admin.reservation-time.index']) }}><a class="nav-link" href="{{ route('admin.reservation-time.index') }}">Reservation time</a></li>
                    <li class= {{ setSidebarActive(['admin.reservation.index']) }}><a class="nav-link" href="{{ route('admin.reservation.index') }}">Reservation</a></li>

                </ul>
            </li>

            @if (auth()->user()->id === 1)
                <li class="{{ setSidebarActive(['admin.chat.*']) }}"><a class="nav-link" href="{{ route('admin.chat.index') }}"><i class="fas fa-comment-dots"></i>
                        <span>Messages</span></a></li>
            @endif

            <li class="dropdown {{
                setSidebarActive([
                    'admin.blog-category.index',
                    'admin.blogs.index',
                    'admin.blogs.comments.index'
                ])
            }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-rss"></i> <span>Blog</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.blog-category.index']) }}"><a class="nav-link" href="{{route('admin.blog-category.index')}}">Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.blogs.index']) }}"><a class="nav-link" href="{{ route('admin.blogs.index') }}">All Blogs</a></li>
                    <li class="{{ setSidebarActive(['admin.blogs.comments.index']) }}"><a class="nav-link" href="{{ route('admin.blogs.comments.index') }}">Comments</a></li>
                </ul>
            </li>

            <li class="{{ setSidebarActive(['admin.news-letter.*']) }}"><a class="nav-link" href="{{ route('admin.news-letter.index') }}"><i class="fas fa-newspaper"></i>
                    <span>News Letter</span></a></li>
            <li class="{{ setSidebarActive(['admin.social-link.*']) }}"><a class="nav-link" href="{{ route('admin.social-link.index') }}"><i class="fas fa-link"></i>
                    <span>Social Links</span></a></li>


            <li class="dropdown {{
                setSidebarActive([
                    'admin.why-choose-us.index',
                    'admin.daily-offer.index',
                    'admin.banner-slider.index',
                    'admin.chefs.index',
                    'admin.app-download.index',
                    'admin.testimonial.index',
                    'admin.counter.index'
                ])
            }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-stream"></i>
                    <span>Sections </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.why-choose-us.index']) }}"><a class="nav-link" href="{{ route('admin.why-choose-us.index') }}">Why choose us</a></li>
                    <li class="{{ setSidebarActive(['admin.daily-offer.index']) }}"><a class="nav-link" href="{{ route('admin.daily-offer.index') }}">Daily Offer</a></li>
                    <li class="{{ setSidebarActive(['admin.banner-slider.index']) }}"><a class="nav-link" href="{{ route('admin.banner-slider.index') }}">Banner Slider</a></li>
                    <li class="{{ setSidebarActive(['admin.chefs.index']) }}"><a class="nav-link" href="{{ route('admin.chefs.index') }}">Chefs</a></li>
                    <li class="{{ setSidebarActive(['admin.app-download.index']) }}"><a class="nav-link" href="{{ route('admin.app-download.index') }}">App Download Section</a></li>
                    <li class="{{ setSidebarActive(['admin.testimonial.index']) }}"><a class="nav-link" href="{{ route('admin.testimonial.index') }}">Testimonial</a></li>
                    <li class="{{ setSidebarActive(['admin.counter.index']) }}"><a class="nav-link" href="{{ route('admin.counter.index') }}">Counter</a></li>

                </ul>
            </li>

            <li class="dropdown {{
                setSidebarActive([
                    'admin.custom-page-builder.index',
                    'admin.about.index',
                    'admin.privacy-policy.index',
                    'admin.contact.index'
                ])
            }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-file-alt"></i>
                    <span>Pages </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.custom-page-builder.index']) }}"><a class="nav-link" href="{{ route('admin.custom-page-builder.index') }}">Custom Page</a></li>
                    <li class="{{ setSidebarActive(['admin.about.index']) }}"><a class="nav-link" href="{{ route('admin.about.index') }}">About</a></li>
                    <li class="{{ setSidebarActive(['admin.privacy-policy.index']) }}"><a class="nav-link" href="{{ route('admin.privacy-policy.index') }}">Privacy Policy</a></li>
                    <li class="{{ setSidebarActive(['admin.contact.index']) }}"><a class="nav-link" href="{{ route('admin.contact.index') }}">Contact</a></li>
                </ul>
            </li>



            <li class="dropdown  {{
                setSidebarActive([
                    'admin.footer-info.index',
                    'admin.footer-links.index',

                ])
            }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-info-circle"></i>
                    <span> Footer </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.footer-info.index']) }}"><a class="nav-link" href="{{ route('admin.footer-info.index') }}">Footer Info</a></li>
                    <li class="{{ setSidebarActive(['admin.footer-links.index']) }}"><a class="nav-link" href="{{ route('admin.footer-links.index') }}">Footer Links</a></li>
                </ul>
            </li>

            <li class="{{ setSidebarActive(['admin.menu-builder.*']) }}"><a class="nav-link" href="{{route('admin.menu-builder.index')}}"><i class="fas fa-list-alt"></i>
                    <span>Menu Builder</span></a></li>

            <li class="{{ setSidebarActive(['admin.admin-management.*']) }}"><a class="nav-link" href="{{route('admin.admin-management.index')}}"><i class="fas fa-user-shield"></i>
                    <span>Admin Management</span></a></li>

            <li class="{{ setSidebarActive(['admin.setting.*']) }}"><a class="nav-link" href="{{route('admin.setting.index')}}"><i class="fas fa-cogs"></i>
                    <span>Settings</span></a></li>

            <li class="{{ setSidebarActive(['admin.clear-database.*']) }}"><a class="nav-link" href="{{ route('admin.clear-database.index') }}"><i class="fas fa-exclamation-triangle"></i>
                    <span>Clear Database</span></a></li>

        </ul>

    </aside>
</div>
