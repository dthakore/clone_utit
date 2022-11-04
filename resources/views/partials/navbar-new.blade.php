<div class="sticky sticky-pin">
    <?php $host = request()->getHttpHost(); ?>
    <aside class="app-sidebar ps ps--active-y">
        <div class="main-sidebar-header active">
            <a class="header-logo active" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/brand/logo.png') }}" class="main-logo  desktop-logo" alt="logo">
                <img src="{{asset('assets/img/brand/logo-white.png')}}" class="main-logo  desktop-dark" alt="logo">
                <img src="{{asset('assets/img/brand/favicon.png')}}" class="main-logo  mobile-logo" alt="logo">
                <img src="{{asset('assets/img/brand/favicon-white.png')}}" class="main-logo  mobile-dark" alt="logo">
            </a>
        </div>

        <div class="main-sidemenu" style="margin-left: 0px">
            <ul class="side-menu">
                <li class="slide navbarLogo" style="height: 57px;">
                    <a class="side-menu__item" href="{{ route('frontend.home') }}">
                        <!-- <img src="{{ asset('/storage/images/logo.png') }}" class="" width="150px" style="margin-top: -6px;" /> -->
                    </a>
                </li>
                @if($host == 'cashback.utradeitrade.com')
                    {{-- <li class="slide">
                        <a class="side-menu__item" href="{{ route('frontend.indexCashback',['id' => isset($url_user_id)? $url_user_id : '' ]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/></svg>
                            <span class="side-menu__label">{{ __('Dashboard') }}</span>
                        </a>
                    </li> --}}
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('frontend.account',['id' => isset($url_user_id)? $url_user_id : '' ]) }}">
                            <i class="fas fa-user"></i>&nbsp;&nbsp;
                            <span class="side-menu__label">{{ __('My Account') }}</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('frontend.cb_geneology',['id' => isset($url_user_id)? $url_user_id : '' ]) }}">
                            <i class="fas fa-bars"></i>&nbsp;&nbsp;
                            <span class="side-menu__label">{{ __('Genealogy') }}</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z"></path><path d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z"></path></svg>
                            <span class="side-menu__label">&nbsp;&nbsp; My Account</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            <li><a class="slide-item {{ request()->is("profile*") ? "active" : "" }}" href="{{ env('APP_URL').'/profile' }}">My Profile</a></li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item"  href="{{ env('APP_URL').'/cb_logout' }}">
                            <i class="fe fe-skip-back side-menu__icon1" ></i>
                            <span class="side-menu__label">&nbsp;&nbsp; Logout</span>
                        </a>
                        <form id="logout-form" action="{{ env('APP_URL').'/cb_logout' }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                        {{--<li class="row">
                            <a class="side-menu__item" href="https://utradeitrade.com">
                                <i class="fas fa-globe"></i>&nbsp;
                                <span class="side-menu__label">{{ __('Go back To UTIT') }}</span>
                            </a>
                            <a class="side-menu__item" href="https://utradeitrade.com/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-user"></i>&nbsp;
                                <span class="side-menu__label">Logout</span>
                            </a>
                            <form id="logout-form" action="https://utradeitrade.com/logout" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>--}}

                @else
                {{--<li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('frontend.home') ? 'active' : '' }}" href="{{ route('frontend.home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/></svg><span class="side-menu__label">{{ __('Dashboard') }}</span>
                    </a>
                </li>--}}
                {{--<li class="slide">--}}
                    {{--<a class="side-menu__item {{ request()->routeIs('frontend.shop') ? 'active' : '' }}" href="{{ route('frontend.shop') }}">--}}
                        {{--<svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20 7h-1.209A4.92 4.92 0 0 0 19 5.5C19 3.57 17.43 2 15.5 2c-1.622 0-2.705 1.482-3.404 3.085C11.407 3.57 10.269 2 8.5 2 6.57 2 5 3.57 5 5.5c0 .596.079 1.089.209 1.5H4c-1.103 0-2 .897-2 2v2c0 1.103.897 2 2 2v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7c1.103 0 2-.897 2-2V9c0-1.103-.897-2-2-2zm-4.5-3c.827 0 1.5.673 1.5 1.5C17 7 16.374 7 16 7h-2.478c.511-1.576 1.253-3 1.978-3zM7 5.5C7 4.673 7.673 4 8.5 4c.888 0 1.714 1.525 2.198 3H8c-.374 0-1 0-1-1.5zM4 9h7v2H4V9zm2 11v-7h5v7H6zm12 0h-5v-7h5v7zm-5-9V9.085L13.017 9H20l.001 2H13z"/></svg><span class="side-menu__label">{{ __('Marketplace') }}</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="slide">--}}
                    {{--<a class="side-menu__item {{ request()->routeIs('follow-expert') ? 'active' : '' }}"  href="{{ route('frontend.expert') }}">--}}
                        {{--<i class="fe fe-user-check side-menu__icon1 "></i>--}}
                        {{--<span class="side-menu__label"> &nbsp;&nbsp;Follow Expert</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('frontend.social') ? 'active' : '' }}" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M2.002 9.63c-.023.411.207.794.581.966l7.504 3.442 3.442 7.503c.164.356.52.583.909.583l.057-.002a1 1 0 0 0 .894-.686l5.595-17.032c.117-.358.023-.753-.243-1.02s-.66-.358-1.02-.243L2.688 8.736a1 1 0 0 0-.686.894zm16.464-3.971-4.182 12.73-2.534-5.522a.998.998 0 0 0-.492-.492L5.734 9.841l12.732-4.182z"/></svg><span class="side-menu__label">{{ __('Socials') }}</span>
                    </a>
                </li>--}}
                {{--<li class="slide">--}}
                    {{--<a class="side-menu__item {{ request()->routeIs('frontend.affiliate') ? 'active' : '' }}" href="{{ route('frontend.affiliate') }}">--}}
                        {{--<svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"/></svg><span class="side-menu__label"> {{ __('My Referrals') }}</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                @can('bot_management_access')
                {{--
                    <li class="slide">
                        <a class="side-menu__item {{ request()->is("exchanges*") ? "active" : "" }} {{ request()->is("user-exchanges*") ? "active" : "" }} {{ request()->is("symbols*") ? "active" : "" }} {{ request()->is("bots*") ? "active" : "" }} {{ request()->is("sessions*") ? "active" : "" }} {{ request()->is("trades*") ? "active" : "" }} {{ request()->is("covers*") ? "active" : "" }}" data-bs-toggle="slide" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg><span class="side-menu__label">{{ trans('cruds.botManagement.title') }}</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">{{ trans('cruds.botManagement.title') }}</a></li>
                            <li><a class="slide-item {{ request()->is("user-exchanges*") ? "active" : "" }}"  href="{{ route('frontend.user-exchanges.index') }}">{{ trans('cruds.userExchange.title') }}</a></li>
                            <li><a class="slide-item {{ request()->is("bots*") ? "active" : "" }}" href="{{ route('frontend.bots.index') }}">{{ trans('cruds.bot.title') }}</a></li>
                        </ul>
                    </li>
                    --}}
                @endcan

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z"></path><path d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z"></path></svg><span class="side-menu__label">&nbsp;&nbsp; My Account</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        {{--<li class="side-menu__label1"><a href="javascript:void(0);">My Account</a></li>--}}
                        <li><a class="slide-item {{ request()->is("profile*") ? "active" : "" }}" href="{{ route('frontend.profile.index') }}">My Profile</a></li>
                        {{--<li><a class="slide-item {{ request()->is("account*") ? "active" : "" }}" href="{{ route('frontend.account',['id' => base64_encode(auth()->user()->id)]) }}">My Account</a></li>--}}
                        {{--<li><a class="slide-item {{ request()->is("order*") ? "active" : "" }}" href="{{ route('frontend.order') }}">My Orders</a></li>--}}
                        {{--<li><a class="slide-item {{ request()->is("license*") ? "active" : "" }}" href="{{ route('frontend.license') }}">My Licenses</a></li>--}}
                        {{--<li><a class="slide-item {{ request()->is("document*") ? "active" : "" }}" href="{{ route('frontend.documents') }}">My documents</a></li>--}}
                        {{--<li><a class="slide-item {{ request()->is("wallet*") ? "active" : "" }}" href="{{ route('frontend.wallet') }}">My Wallet</a></li>--}}
                        {{--<li><a class="slide-item {{ request()->is("password*") ? "active" : "" }}" href="{{ route('frontend.password') }}">Change Password</a></li>--}}
                        @if (auth()->user()->is_admin)
                            <li><a class="slide-item" href="{{ url('/admin') }}">Go to Admin</a></li>
                        @endif
                        {{--<form id="logout-form" action="{{ route('sio.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <li><a class="slide-item" href="{{ route('sio.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>--}}
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="{{ route('sio.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe fe-skip-back side-menu__icon1" ></i>
                        <span class="side-menu__label">&nbsp;&nbsp; Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('sio.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
               {{-- <li class="slide" style=" margin-left: auto;margin-right: 0;padding-right: 14px;">
                    <a class="side-menu__item {{ request()->routeIs('frontend.order.cart') ? 'active' : '' }}" href="{{ route('frontend.order.cart') }}">
                        <i class="fe fe-shopping-cart tx-40 cart-badge" id="cart-quantity" style="font-size:20px;padding: 0" value=@php $total_qty = \App\Models\Cart::where(['user_id' => auth()->user()->id])->sum('product_qty');echo $total_qty;@endphp></i>
                    </a>
                </li>--}}
                @endif
            </ul>

        </div>
    </aside>
</div>
