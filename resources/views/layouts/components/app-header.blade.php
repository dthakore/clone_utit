<!-- main-header -->
<div class="main-header side-header sticky nav nav-item">
    <div class=" main-container container-fluid">
        <div class="main-header-left ">
            <?php
            $host = request()->getHttpHost();
            if ($host != 'cashback.utradeitrade.com'):

                $announcement = \Auth::user()->userUserAlerts()
                    ->where(['show_hide' => 1])
                    ->whereRaw("find_in_set('2',type)")->get();
            endif;
            ?>
            <div class="responsive-logo">
                <a href="{{ url('/') }}" class="header-logo">
                    <img src="{{ asset('/storage/images/logo.png') }}" class="mobile-logo logo-1" alt="logo">
                </a>
            </div>

            <div class="left-content">
                {{-- <a class="side" href="{{ url('/') }}">
                        <img src="{{ asset('/storage/images/logo.png') }}" class="main-content-title mg-b-0 mg-b-lg-1 d-inline-block" width="150px" />
                </a> --}}
                <div class="justify-content-center mt-2 d-inline-block">
                    <ol class=" home_top_menu mb-2">

                        <li class="tx-15">
                            @if($host == 'cashback.utradeitrade.com')
                                <a class="side-menu__itemTop"
                                   href="{{ route('frontend.indexCashback',['id' => isset($url_user_id)? $url_user_id : '' ]) }}">
                                    <i class="fe fe-home side-menu__icon"></i>
                                    <span class="side-menu__labelTop">{{ __('Dashboard') }}</span>
                                </a>
                            @else
                                <a class="side-menu__itemTop" href="{{ route('frontend.home') }}">
                                    <i class="fe fe-home side-menu__icon"></i>
                                    <span class="side-menu__labelTop">{{ __('Dashboard') }}</span>
                                </a>
                            @endif
                        </li>
                        <li class="tx-15">
                            <a href="#" class="side-menu__itemTop">
                                <i class="fe fe-help-circle side-menu__icon"></i>
                                <span class="side-menu__labelTop">Help</span>
                            </a></li>
                    </ol>
                </div>
            </div>
            <div class="main-header-right">
                <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <ul class="nav nav-item header-icons navbar-nav-right ms-auto">
                            <li class="dropdown nav-item main-header-notification d-flex">
                                <a class="new nav-link" data-bs-toggle="dropdown" href="javascript:void(0);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24"
                                         height="24" viewBox="0 0 24 24">
                                        <path d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z"/>
                                    </svg>
                                    <span class=" pulse"></span>
                                </a>
                                @if ($host != 'cashback.utradeitrade.com')
                                    <div class="dropdown-menu">
                                        @if(!$announcement->isEmpty())
                                            <div class="menu-header-content text-start border-bottom">
                                                <div class="d-flex">
                                                    <h6 class="dropdown-title mb-1 tx-15 font-weight-semibold">
                                                        Notifications</h6>
                                                    <!-- <span class="badge badge-pill badge-warning ms-auto my-auto float-end">Mark All Read</span> -->
                                                </div>
                                                <p class="dropdown-title-text subtext mb-0 op-6 pb-0 tx-12 ">You
                                                    have {{$announcement->count()}} unread Notifications</p>
                                            </div>
                                            <div class="main-notification-list Notification-scroll">

                                                @foreach($announcement as $anc)
                                                    <a class="d-flex p-3 border-bottom" href="#">
                                                        <div class="notifyimg heightFix bg-pink">
                                                            <i class="far fa-envelope-open text-white"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <h5 class="notification-label mb-1">{{$anc->alert_text}}</h5>
                                                            <div class="notification-subtext">{{ date("M d, Y", strtotime($anc->created_at)) }}</div>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <i class="las la-angle-right text-end text-muted"></i>
                                                        </div>
                                                    </a>
                                                @endforeach

                                            </div>
                                    @endif
                                    <!-- <div class="dropdown-footer">
                                                                                <a class="btn btn-primary btn-sm btn-block" href="https://laravel8.spruko.com/nowa/mail">VIEW ALL</a>
                                                                        </div> -->
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if($host != 'cashback.utradeitrade.com')
                @php
                    $total_qty = \App\Models\Cart::where(['user_id' => auth()->user()->id])->sum('product_qty');
                    $platform_product = \App\Models\Product::where('sku', 'NTTP1')->first();
        if(!empty($platform_product->id)) {
        $platform_cart = \App\Models\Cart::where(['user_id' => auth()->user()->id, 'product_id' => $platform_product->id])->first();
        if (!empty($platform_cart->cart_id)) {
            $total_qty = $total_qty - $platform_cart->product_qty + 1;
        }
        }
                @endphp
                <a class="side-menu__item utit_cart_icon " href="{{ route('frontend.order.cart') }}">
                    <i class="fe fe-shopping-cart tx-40 cart-badge" id="cart-quantity" style="font-size:20px;padding: 0"
                       value={{$total_qty}}></i>
                </a>
            @endif

            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>

            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
