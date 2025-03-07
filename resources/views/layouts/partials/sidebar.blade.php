<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid" style="min-height:0">

        @php
            $websetting = App\Models\WebSetting::first();

            $server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');
        @endphp
        <!-- Brand -->
        <a class="navbar-brand " href="{{ route('root') }}">
            <img src="{{ $websetting->websiteLogoPath ?? asset('web/logo.png') }}" class="navbar-brand-img"
                alt="Admin Logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerGoldStar"
            aria-controls="navbarTogglerGoldStar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarTogglerGoldStar">

            <ul class="navbar-nav">
                <div class="position-absolute top-0 right-0 d-md-none navbarCloseBtn" data-toggle="collapse"
                    data-target="#navbarTogglerGoldStar">
                    <i class="fas fa-angle-left"></i>
                </div>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('root') ? 'active' : '' }}" href="{{ route('root') }}">
                        <i class="fa fa-desktop text-teal"></i>
                        <span class="nav-link-text">{{ __('Dashboard') }}</span>
                    </a>
                </li>


                @role('customer')

                        <li class="nav-item">

                            <span class="nav-link-text">
                                <p class="nav-link"><b>Selamat Datang {{ auth()->user()->company }}</b></p>
                            </span>

                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}"
                                href="{{ route('order.index') }}">
                                <i class="fa fa-file text-blue"></i>
                                <span class="nav-link-text">{{ __('Retur Approval') }}</span>
                            </a>
                        </li>

                        <li  class="nav-item">
                            <a class="nav-link {{ request()->routeIs('garansi.*') ? 'active' : '' }} "
                                href="#garansi_saya" data-toggle="collapse" aria-expanded="false" role="button"
                                aria-controls="navbar-examples">
                                <i class="fa fa-file text-blue"></i>
                                <span class="nav-link-text">{{ __('Garansi Saya') }}</span>
                            </a>

                            <div class="collapse {{ request()->routeIs('setting.*','garansi.*', 'klaim.*') ? 'show' : '' }}"
                                id="garansi_saya">
                                <ul class="nav nav-sm flex-column">
                                    <a class="nav-link sub-menu {{ request()->routeIs('garansi.index') ? 'active' : '' }} "
                                        href="{{ route('garansi.index') }}" href="{{ route('garansi.index') }}">
                                        <span class="nav-link-text">{{ __('Cek Status') }}</span>
                                    </a>

                                    {{-- <a class="nav-link sub-menu {{ request()->routeIs('garansi.create') ? 'active' : '' }}"
                                        href="{{ route('garansi.create') }}" href="{{ route('garansi.create') }}">
                                        <span class="nav-link-text">{{ __('Tambah Masa Proteksi') }}</span>
                                    </a> --}}

                                    <a class="nav-link sub-menu {{ request()->routeIs('klaim.*') ? 'active' : '' }}"
                                        href="{{ route('klaim.index') }}" href="{{ route('klaim.index') }}">
                                        <span class="nav-link-text">{{ __('Klaim Garansi') }}</span>
                                    </a>

                                    <a class="nav-link sub-menu {{ url()->full() == config('app.url') . '/settings/faq'  ? 'active' : '' }}"
                                        href="{{ route('setting.show', 'faq') }}" >
                                        <span class="nav-link-text">{{ __('Faq Garansi') }}</span>
                                    </a>

                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sub-menu {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                                href="{{ route('profile.index') }}">
                                <i class="fas fa-user"></i>
                                <span class="nav-link-text">{{ __('Profile') }}</span>
                            </a>
                        </li>

                        <!-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('garansi.*') ? 'active' : '' }}"
                                href="{{ route('garansi.index') }}">
                                <i class="fa fa-file text-blue"></i>
                                <span class="nav-link-text">{{ __('Data Garansi') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('klaim.*') ? 'active' : '' }}"
                                href="{{ route('klaim.index') }}">
                                <i class="fas fa-list text-green"></i>
                                <span class="nav-link-text">{{ __('Data Klaim') }}</span>
                            </a>
                        </li> -->
                @endrole


                @role('root')

                    <li class="nav-item">
                        <a class="nav-link  {{ request()->routeIs('banner.promotional') ? 'active' : '' }}"
                            href="{{ route('banner.promotional') }}">
                            <i class="fas fa-image text-dark"></i>
                            <span class="nav-link-text">{{ __('Banners') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('garansi.*') ? 'active' : '' }}"
                            href="{{ route('garansi.index') }}">
                            <i class="fa fa-file text-blue"></i>
                            <span class="nav-link-text">{{ __('Customer Saya') }} </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coupon.*') ? 'active' : '' }}"
                            href="{{ route('coupon.index') }}">
                            <i class="fa fa-percentage"></i>
                            <span class="nav-link-text">{{ __('Data Kode') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}"
                            href="{{ route('order.index') }}">
                            <i class="fa fa-shopping-cart text-orange"></i>
                            <span class="nav-link-text">{{ __('Data Retur') }}</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('klaim.*') ? 'active' : '' }}"
                            href="{{ route('klaim.index') }}">
                            <i class="fas fa-list text-green"></i>
                            <span class="nav-link-text">{{ __('Data Klaim') }}</span>
                        </a>
                    </li>
                @endrole

                @role('admin')


                <li class="nav-item">
                        <a class="nav-link  {{ request()->routeIs('banner.promotional') ? 'active' : '' }}"
                            href="{{ route('banner.promotional') }}">
                            <i class="fas fa-image text-dark"></i>
                            <span class="nav-link-text">{{ __('Banners') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('garansi.*') ? 'active' : '' }}"
                            href="{{ route('garansi.index') }}">
                            <i class="fa fa-file text-blue"></i>
                            <span class="nav-link-text">{{ __('Customer Saya') }} </span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('klaim.*') ? 'active' : '' }}"
                            href="{{ route('klaim.index') }}">
                            <i class="fas fa-list text-green"></i>
                            <span class="nav-link-text">{{ __('Data Klaim') }}</span>
                        </a>
                    </li>
                @endrole

                @role('visitor')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coupon.*') ? 'active' : '' }}"
                            href="{{ route('coupon.index') }}">
                            <i class="fa fa-percentage"></i>
                            <span class="nav-link-text">{{ __('Data Kode') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}"
                            href="{{ route('order.index') }}">
                            <i class="fa fa-shopping-cart text-orange"></i>
                            <span class="nav-link-text">{{ __('Data Retur') }}</span>
                        </a>
                    </li>
                @endrole

                @canany(['product.index', 'coupon.index', 'variant.index', 'service.index'])
                    <li hidden class="nav-item">
                        <a class="nav-link  {{ request()->routeIs('service.*', 'variant.*', 'product.*', 'coupon.*') ? 'active' : '' }}"
                            href="#product_manage" data-toggle="collapse" aria-expanded="false" role="button"
                            aria-controls="navbar-examples">
                            <i class="fas fa-warehouse text-primary"></i>
                            <span class="nav-link-text">{{ __('Product_Manage') }}</span>
                        </a>

                        <div class="collapse {{ request()->routeIs('service.*', 'additional.*', 'variant.*', 'product.*', 'coupon.*') ? 'show' : '' }}"
                            id="product_manage">
                            <ul class="nav nav-sm flex-column">
                                @can('service.index')
                                    <a class="nav-link sub-menu {{ request()->routeIs('service.*') ? 'active' : '' }} {{ request()->routeIs('additional.*') ? 'active' : '' }}"
                                        href="{{ route('service.index') }}" href="{{ route('service.index') }}">
                                        {{-- <i class="fas fa-cogs"></i> --}}
                                        <i class="fas fa-tools"></i>
                                        <span class="nav-link-text">{{ __('Services') }}</span>
                                    </a>
                                @endcan

                                @can('variant.index')
                                    <a class="nav-link sub-menu {{ request()->routeIs('variant.*') ? 'active' : '' }}"
                                        href="{{ route('variant.index') }}">
                                        <i class="fas fa-list"></i>
                                        <span class="nav-link-text">{{ __('Variants') }}</span>
                                    </a>
                                @endcan
                                @can('product.index')
                                    <a class="nav-link sub-menu {{ request()->routeIs('product.*') ? 'active' : '' }}"
                                        href="{{ route('product.index') }}">
                                        <i class="fas fa-boxes"></i>
                                        <span class="nav-link-text">{{ __('Products') }}</span>
                                    </a>
                                @endcan

                                @can('coupon.index')
                                    <a hidden class="nav-link sub-menu {{ request()->routeIs('coupon.*') ? 'active' : '' }}"
                                        href="{{ route('coupon.index') }}">
                                        <i class="fa fa-percentage"></i>
                                        <span class="nav-link-text">{{ __('Coupon') }}</span>
                                    </a>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @can('notification.index')
                    <li hidden class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notification.*') ? 'active' : '' }}"
                            href="{{ route('notification.index') }}">
                            <i class="fas fa-bell text-primary"></i>
                            <span class="nav-link-text">{{ __('Notifications') }}</span>
                        </a>
                    </li>
                @endcan

                @can('revenue.index')
                    <li hidden class="nav-item">
                        <a class="nav-link {{ request()->routeIs('revenue.*') ? 'active' : '' }}"
                            href="{{ route('revenue.index', ['from' => now()->subMonth(1)->format('Y-m-d'),'to' => now()->addDay(1)->format('Y-m-d')]) }}">
                            <i class="fa fa-file text-red"></i>
                            <span class="nav-link-text">{{ __('Reports') }}</span>
                        </a>
                    </li>
                @endcan


                @can('driver.index')
                    <li hidden class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.*') ? 'active' : '' }}"
                            href="{{ route('driver.index') }}">
                            <i class="fas fa-shipping-fast text-orange"></i>
                            <span class="nav-link-text">{{ __('Drivers') }}</span>
                        </a>
                    </li>
                @endcan

                @can('contact')
                    <li hidden class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">
                            <i class="fa fa-comment text-purple"></i>
                            <span class="nav-link-text">{{ __('Contacts') }}</span>
                        </a>
                    </li>
                @endcan

                @role('root')
                    <li hidden class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                            href="{{ route('admin.index') }}">
                            <i class="fas fa-user-secret"></i>
                            <span class="nav-link-text">{{ __('Data Admins') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{ request()->routeIs('setting.*','admin.*', 'deliveryCost', 'mobileApp', 'socialLink.*', 'webSetting.*', 'stripeKey.*', 'notification.manage', 'fcm.*', 'mail-config.*') ? 'active' : '' }}"
                            href="#setting" data-toggle="collapse" aria-expanded="false" role="button"
                            aria-controls="navbar-examples">
                            <i class="fa fa-cog text-red"></i>
                            <span class="nav-link-text">{{ __('Settings') }}</span>
                        </a>

                        <div class="collapse {{ request()->routeIs('setting.*','customer.*','admin.*', 'deliveryCost', 'mobileApp', 'socialLink.*', 'profile.*', 'webSetting.*', 'stripeKey.*', 'schedule.*', 'invoiceManage.*', 'areas.*', 'sms-gateway.*', 'notification.manage', 'fcm.*', 'mail-config.*') ? 'show' : '' }}"
                            id="setting">
                            <ul class="nav nav-sm flex-column">
                                @foreach (config('enums.settings') as $index => $item)
                                    <a class="nav-link sub-menu {{ url()->full() == config('app.url') . '/settings/' . $index || url()->full() == config('app.url') . '/settings/' . $index . '/edit' ? 'active' : '' }}"
                                        href="{{ route('setting.show', $index) }}">
                                        @if ($index == 'faq')
                                            <i class="fas fa-vote-yea"></i>
                                        @endif
                                        @if ($index == 'trams-of-service')
                                            <i class="fas fa-toilet-paper"></i>
                                        @endif
                                        @if ($index == 'contact-us')
                                            <i class="fas fa-envelope-open-text"></i>
                                        @endif
                                        @if ($index == 'about-us')
                                            <i class="fas fa-info-circle"></i>
                                        @endif
                                        <span class="nav-link-text">{{ $item }}</span>
                                    </a>
                                @endforeach
                                <a hidden class="nav-link sub-menu {{ request()->routeIs('deliveryCost') ? 'active' : '' }}"
                                    href="{{ route('deliveryCost') }}">
                                    <i class="fa fa-dollar-sign"></i>
                                    <span class="nav-link-text">{{ __('Delivery Cost') }}</span>
                                </a>
                                <a hidden class="nav-link sub-menu {{ request()->routeIs('mobileApp') ? 'active' : '' }}"
                                    href="{{ route('mobileApp') }}">
                                    <i class="fa fa-link"></i>
                                    <span class="nav-link-text">{{ __('Mobile App Link') }}</span>
                                </a>
                                <a hidden class="nav-link sub-menu {{ request()->routeIs('socialLink.*') ? 'active' : '' }}"
                                    href="{{ route('socialLink.index') }}">
                                    <i class="fa fa-icons"></i>
                                    <span class="nav-link-text">{{ __('Social Links') }}</span>
                                </a>
                                <a hidden class="nav-link sub-menu {{ url()->full() == config('app.url') . '/pickup/scheduls' ? 'active' : '' }}"
                                    href="{{ route('schedule.index', 'pickup') }}">
                                    <i class="fas fa-clock"></i>
                                    <span class="nav-link-text">{{ __('P. Schedules') }}</span>
                                </a>
                                <a hidden class="nav-link sub-menu {{ url()->full() == config('app.url') . '/delivery/scheduls' ? 'active' : '' }}"
                                    href="{{ route('schedule.index', 'delivery') }}">
                                    <i class="fas fa-clock"></i>
                                    <span class="nav-link-text">{{ __('D. Schedules') }}</span>
                                </a>

                                <a hidden class="nav-link sub-menu {{ request()->routeIs('stripeKey.*') ? 'active' : '' }}"
                                    href="{{ route('stripeKey.index') }}">
                                    <i class="fab fa-cc-stripe"></i>
                                    <span class="nav-link-text">{{ __('Stripe payment') }}</span>
                                </a>
                                <a hidden class="nav-link sub-menu {{ request()->routeIs('sms-gateway.*') ? 'active' : '' }}"
                                    href="{{ route('sms-gateway.index') }}">
                                    <i class="fas fa-sms"></i>
                                    <span class="nav-link-text">{{ __('SMS Gateway') }}</span>
                                </a>
                                <a hidden class="nav-link sub-menu {{ request()->routeIs('invoiceManage.*') ? 'active' : '' }}"
                                    href="{{ route('invoiceManage.index') }}">
                                    <i class="fas fa-print"></i>
                                    <span class="nav-link-text">{{ __('Invoice Manage') }}</span>
                                </a>

                                <a hidden class="nav-link sub-menu {{ request()->routeIs('notification.manage') ? 'active' : '' }}"
                                    href="{{ route('notification.manage') }}">
                                    <i class="fas fa-bell"></i>
                                    <span class="nav-link-text">{{ __('Notify.. Manage') }}</span>
                                </a>

                                <a hidden class="nav-link sub-menu {{ request()->routeIs('fcm.*') ? 'active' : '' }}"
                                    href="{{ route('fcm.index') }}">
                                    <i class="fas fa-cloud"></i>
                                    <span class="nav-link-text">{{ __('FCM Config') }}</span>
                                </a>
                                <a hidden class="nav-link sub-menu {{ request()->routeIs('areas.*') ? 'active' : '' }}"
                                    href="{{ route('areas.index') }}">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="nav-link-text">{{ __('Areas') }}</span>
                                </a>

                                <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                                    href="{{ route('admin.index') }}">
                                    <i class="fas fa-user-secret"></i>
                                    <span class="nav-link-text">{{ __('Data Admins') }}</span>
                                </a>

                                <a class="nav-link sub-menu {{ request()->routeIs('customer.*') ? 'active' : '' }}"
                                    href="{{ route('customer.index') }}">
                                    <i class="fa fa-users"></i>
                                    <span class="nav-link-text">{{ __('Data Customers') }}</span>
                                </a>

                                <a class="nav-link sub-menu {{ request()->routeIs('mail-config.*') ? 'active' : '' }}"
                                    href="{{ route('mail-config.index') }}">
                                    <i class="fas fa-envelope"></i>
                                    <span class="nav-link-text">{{ __('Mail Config') }}</span>
                                </a>

                                <a class="nav-link sub-menu {{ request()->routeIs('webSetting.*') ? 'active' : '' }}"
                                    href="{{ route('webSetting.index') }}">
                                    <i class="fas fa-globe"></i>
                                    <span class="nav-link-text">{{ __('Web Setting') }}</span>
                                </a>
                            </ul>
                        </div>
                    </li>
                @endrole

                @can('profile.index')
                    <li class="nav-item">
                        <a class="nav-link sub-menu {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                            href="{{ route('profile.index') }}">
                            <i class="fas fa-user"></i>
                            <span class="nav-link-text">{{ __('Profile') }}</span>
                        </a>
                    </li>
                @endcan


                <li class="nav-item">
                    <a class="nav-link"
                        onclick="event.preventDefault();
                        document.getElementById('logout').submit()"
                        href="#">
                        <i class="fas fa-sign-out-alt text-warning"></i>
                        <span class="nav-link-text">{{ __('Logout') }}</span>
                    </a>
                    <form id="logout" action="{{ route('logout') }}" method="POST"> @csrf </form>
                </li>

            </ul>
        </div>
        <div class="footer_bottom">
            <div hidden class="local">
                <i class="fa fa-language lanIcon"></i>
                <select id="language" name="ln" class="form-control">
                    <option value="en" {{ session()->get('local') == 'en' ? 'selected' : '' }}>English
                    </option>
                    <option value="ar" {{ session()->get('local') == 'ar' ? 'selected' : '' }}>Arabic</option>
                </select>
            </div>
            <div class="profile d-flex justify-content-start">
                <div>
                    <img src="{{ auth()->user()->profile_photo_path }}" alt="" width="50"
                        height="50">
                </div>
                <div>
                    <h3 class="name m-0">{{ auth()->user()->name }}</h3>
                    <p class="email m-0">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>

</nav>
