<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        {{--<img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
        <img src="{{ asset(env('PUXEO_URL').$tenant['logo']) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"/>
        <span class="brand-text font-weight-light">{{ $tenant['app_name']; }} | Puxeo</span>
    </a>

    <div class="sidebar">
        @guest
        @else
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('frontend.profile.index') }}" class="d-block">{{ Auth::user()->name }}</a>
                    <a class="pull-right" href="{{ route('sio.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>
                </div>


                <form id="logout-form" action="{{ route('sio.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @can('bot_management_access')
                        <li class="nav-item {{ request()->is("exchanges*") ? "menu-open" : "" }} {{ request()->is("user-exchanges*") ? "menu-open" : "" }} {{ request()->is("symbols*") ? "menu-open" : "" }} {{ request()->is("bots*") ? "menu-open" : "" }} {{ request()->is("sessions*") ? "menu-open" : "" }} {{ request()->is("trades*") ? "menu-open" : "" }} {{ request()->is("covers*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("exchanges*") ? "active" : "" }} {{ request()->is("user-exchanges*") ? "active" : "" }} {{ request()->is("symbols*") ? "active" : "" }} {{ request()->is("bots*") ? "active" : "" }} {{ request()->is("sessions*") ? "active" : "" }} {{ request()->is("trades*") ? "active" : "" }} {{ request()->is("covers*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-robot"></i>
                                <p>
                                    {{ trans('cruds.botManagement.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('user_exchange_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.user-exchanges.index') }}" class="nav-link {{ request()->is("user-exchanges*") ? "active" : "" }}">
                                            <i class="fas fa-chart-line nav-icon"></i>
                                            <p>{{ trans('cruds.userExchange.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('bot_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.bots.index') }}" class="nav-link {{ request()->is("bots*") ? "active" : "" }}">
                                            <i class="fas fa-robot nav-icon"></i>
                                            <p>{{ trans('cruds.bot.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                {{--@can('trade_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.trades.index') }}" class="nav-link {{ request()->is("trades*") ? "active" : "" }}">
                                            <i class="far fa-chart-bar nav-icon"></i>
                                            <p>{{ trans('cruds.trade.title') }}</p>
                                        </a>
                                    </li>
                                @endcan--}}
                            </ul>
                        </li>
                    @endcan
                    @can('system_account_access')
                        <li class="nav-item {{ request()->is("user-position-accounts*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("user-position-accounts*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    {{ trans('cruds.systemAccount.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('user_position_account_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.user-position-accounts.index') }}" class="nav-link {{ request()->is("user-position-accounts*") ? "active" : "" }}">
                                            <i class="fas fa-user nav-icon"></i>
                                            <p>{{ trans('cruds.userPositionAccount.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('commission_plan_access')
                        <li class="nav-item {{ request()->is("plans*") ? "menu-open" : "" }} {{ request()->is("commission-rules*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("plans*") ? "active" : "" }} {{ request()->is("commission-rules*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-euro-sign"></i>
                                <p>
                                    {{ trans('cruds.commissionPlan.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('plan_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.plans.index') }}" class="nav-link {{ request()->is("plans*") ? "active" : "" }}">
                                            <i class="fas fa-money-check nav-icon"></i>
                                            <p>{{ trans('cruds.plan.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('commission_rule_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.commission-rules.index') }}" class="nav-link {{ request()->is("commission-rules*") ? "active" : "" }}">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>{{ trans('cruds.commissionRule.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('e_commerce_access')
                        <li class="nav-item {{ request()->is("products*") ? "menu-open" : "" }} {{ request()->is("product-categories*") ? "menu-open" : "" }} {{ request()->is("product-tags*") ? "menu-open" : "" }} {{ request()->is("orders*") ? "menu-open" : "" }} {{ request()->is("shipment-infos*") ? "menu-open" : "" }} {{ request()->is("order-credit-memos*") ? "menu-open" : "" }} {{ request()->is("payments*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("products*") ? "active" : "" }} {{ request()->is("product-categories*") ? "active" : "" }} {{ request()->is("product-tags*") ? "active" : "" }} {{ request()->is("orders*") ? "active" : "" }} {{ request()->is("shipment-infos*") ? "active" : "" }} {{ request()->is("order-credit-memos*") ? "active" : "" }} {{ request()->is("payments*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-align-justify"></i>
                                <p>
                                    {{ trans('cruds.eCommerce.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('product_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.products.index') }}" class="nav-link {{ request()->is("products*") ? "active" : "" }}">
                                            <i class="fas fa-shopping-cart nav-icon"></i>
                                            <p>{{ trans('cruds.product.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('product_category_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.product-categories.index') }}" class="nav-link {{ request()->is("product-categories*") ? "active" : "" }}">
                                            <i class="fas fa-folder nav-icon"></i>
                                            <p>{{ trans('cruds.productCategory.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                <!-- @can('product_tag_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.product-tags.index') }}" class="nav-link {{ request()->is("product-tags*") ? "active" : "" }}">
                                            <i class="fas fa-tags nav-icon"></i>
                                            <p>{{ trans('cruds.productTag.title') }}</p>
                                        </a>
                                    </li>
                                @endcan -->
                                @can('order_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.orders.index') }}" class="nav-link {{ request()->is("orders*") ? "active" : "" }}">
                                            <i class="fas fa-luggage-cart nav-icon"></i>
                                            <p>{{ trans('cruds.order.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('payment_access')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is("payment*") ? "active" : "" }}" href="{{ route('frontend.payments.index') }}">
                                            <i class="fa-fw nav-icon fab fa-amazon-pay"></i>
                                            <p>{{ trans('cruds.payment.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                <!-- @can('shipment_info_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.shipment-infos.index') }}" class="nav-link {{ request()->is("shipment-infos*") ? "active" : "" }}">
                                            <i class="fas fa-shipping-fast nav-icon"></i>
                                            <p>{{ trans('cruds.shipmentInfo.title') }}</p>
                                        </a>
                                    </li>
                                @endcan -->
                                @can('order_credit_memo_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.order-credit-memos.index') }}" class="nav-link {{ request()->is("order-credit-memos*") ? "active" : "" }}">
                                            <i class="far fa-credit-card nav-icon"></i>
                                            <p>{{ trans('cruds.orderCreditMemo.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('mt_four_manager_access')
                        <li class="nav-item {{ request()->is("mt-four-brokers*") ? "menu-open" : "" }} {{ request()->is("cbm-mt-four-accounts*") ? "menu-open" : "" }} {{ request()->is("mt-four-deposit-withdraws*") ? "menu-open" : "" }} {{ request()->is("mt-four-trades*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("mt-four-brokers*") ? "active" : "" }} {{ request()->is("cbm-mt-four-accounts*") ? "active" : "" }} {{ request()->is("mt-four-deposit-withdraws*") ? "active" : "" }} {{ request()->is("mt-four-trades*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-ticket-alt"></i>
                                <p>
                                    {{ trans('cruds.mtFourManager.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('mt_four_broker_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.mt-four-brokers.index') }}" class="nav-link {{ request()->is("mt-four-brokers*") ? "active" : "" }}">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>{{ trans('cruds.mtFourBroker.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('cbm_mt_four_account_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.cbm-mt-four-accounts.index') }}" class="nav-link {{ request()->is("cbm-mt-four-accounts*") ? "active" : "" }}">
                                            <i class="fas fa-user nav-icon"></i>
                                            <p>{{ trans('cruds.cbmMtFourAccount.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('mt_four_deposit_withdraw_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.mt-four-deposit-withdraws.index') }}" class="nav-link {{ request()->is("mt-four-deposit-withdraws*") ? "active" : "" }}">
                                            <i class="fas fa-book-open nav-icon"></i>
                                            <p>{{ trans('cruds.mtFourDepositWithdraw.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('mt_four_trade_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.mt-four-trades.index') }}" class="nav-link {{ request()->is("mt-four-trades*") ? "active" : "" }}">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>{{ trans('cruds.mtFourTrade.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('wallet_management_access')
                        <li class="nav-item {{ request()->is("denominations*") ? "menu-open" : "" }} {{ request()->is("wallet-types*") ? "menu-open" : "" }} {{ request()->is("wallet-meta-types*") ? "menu-open" : "" }} {{ request()->is("allwallettransactions*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("denominations*") ? "active" : "" }} {{ request()->is("wallet-types*") ? "active" : "" }} {{ request()->is("wallet-meta-types*") ? "active" : "" }} {{ request()->is("allwallettransactions*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    {{ trans('cruds.walletManagement.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('denomination_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.denominations.index') }}" class="nav-link {{ request()->is("denominations*") ? "active" : "" }}">
                                            <i class="fas fa-receipt nav-icon"></i>
                                            <p>{{ trans('cruds.denomination.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('wallet_type_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.wallet-types.index') }}" class="nav-link {{ request()->is("wallet-types*") ? "active" : "" }}">
                                            <i class="fas fa-money-check nav-icon"></i>
                                            <p>{{ trans('cruds.walletType.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('wallet_meta_type_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.wallet-meta-types.index') }}" class="nav-link {{ request()->is("wallet-meta-types*") ? "active" : "" }}">
                                            <i class="fas fa-piggy-bank nav-icon"></i>
                                            <p>{{ trans('cruds.walletMetaType.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('allwallettransaction_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.allwallettransactions.index') }}" class="nav-link {{ request()->is("allwallettransactions*") ? "active" : "" }}">
                                            <i class="fas fa-wallet nav-icon"></i>
                                            <p>{{ trans('cruds.allwallettransaction.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('faq_management_access')
                        <li class="nav-item {{ request()->is("faq-categories*") ? "menu-open" : "" }} {{ request()->is("faq-questions*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("faq-categories*") ? "active" : "" }} {{ request()->is("faq-questions*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-question"></i>
                                <p>
                                    {{ trans('cruds.faqManagement.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('faq_category_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.faq-categories.index') }}" class="nav-link {{ request()->is("faq-categories*") ? "active" : "" }}">
                                            <i class="fas fa-briefcase nav-icon"></i>
                                            <p>{{ trans('cruds.faqCategory.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('faq_question_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.faq-questions.index') }}" class="nav-link {{ request()->is("faq-questions*") ? "active" : "" }}">
                                            <i class="fas fa-question nav-icon"></i>
                                            <p>{{ trans('cruds.faqQuestion.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('contact_management_access')
                        <li class="nav-item {{ request()->is("contact-companies*") ? "menu-open" : "" }} {{ request()->is("contact-contacts*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("contact-companies*") ? "active" : "" }} {{ request()->is("contact-contacts*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-phone-square"></i>
                                <p>
                                    {{ trans('cruds.contactManagement.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('contact_company_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.contact-companies.index') }}" class="nav-link {{ request()->is("contact-companies*") ? "active" : "" }}">
                                            <i class="fas fa-building nav-icon"></i>
                                            <p>{{ trans('cruds.contactCompany.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('contact_contact_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.contact-contacts.index') }}" class="nav-link {{ request()->is("contact-contacts*") ? "active" : "" }}">
                                            <i class="fas fa-user-plus nav-icon"></i>
                                            <p>{{ trans('cruds.contactContact.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('courses_management_access')
                        <li class="nav-item {{ request()->is("courses*") ? "menu-open" : "" }} {{ request()->is("lessons*") ? "menu-open" : "" }} {{ request()->is("tests*") ? "menu-open" : "" }} {{ request()->is("questions*") ? "menu-open" : "" }} {{ request()->is("question-options*") ? "menu-open" : "" }} {{ request()->is("test-results*") ? "menu-open" : "" }} {{ request()->is("test-answers*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->is("courses*") ? "active" : "" }} {{ request()->is("lessons*") ? "active" : "" }} {{ request()->is("tests*") ? "active" : "" }} {{ request()->is("questions*") ? "active" : "" }} {{ request()->is("question-options*") ? "active" : "" }} {{ request()->is("test-results*") ? "active" : "" }} {{ request()->is("test-answers*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    {{ trans('cruds.coursesManagement.title') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('course_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.courses.index') }}" class="nav-link {{ request()->is("courses*") ? "active" : "" }}">
                                            <i class="fas fa-graduation-cap nav-icon"></i>
                                            <p>{{ trans('cruds.course.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('lesson_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.lessons.index') }}" class="nav-link {{ request()->is("lessons*") ? "active" : "" }}">
                                            <i class="fas fa-book-reader nav-icon"></i>
                                            <p>{{ trans('cruds.lesson.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('test_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.tests.index') }}" class="nav-link {{ request()->is("tests*") ? "active" : "" }}">
                                            <i class="fas fa-microscope nav-icon"></i>
                                            <p>{{ trans('cruds.test.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('question_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.questions.index') }}" class="nav-link {{ request()->is("questions*") ? "active" : "" }}">
                                            <i class="fas fa-question nav-icon"></i>
                                            <p>{{ trans('cruds.question.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('question_option_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.question-options.index') }}" class="nav-link {{ request()->is("question-options*") ? "active" : "" }}">
                                            <i class="far fas fa-chalkboard nav-icon"></i>
                                            <p>{{ trans('cruds.questionOption.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('test_result_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.test-results.index') }}" class="nav-link {{ request()->is("test-results*") ? "active" : "" }}">
                                            <i class="fas fa-file nav-icon"></i>
                                            <p>{{ trans('cruds.testResult.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('test_answer_access')
                                    <li class="nav-item">
                                        <a href="{{ route('frontend.test-answers.index') }}" class="nav-link {{ request()->is("test-answers*") ? "active" : "" }}">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>{{ trans('cruds.testAnswer.title') }}</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('user_alert_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.user-alerts.index") }}" class="nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                                <i class="fa-fw nav-icon fas fa-bell">

                                </i>
                                <p>
                                    {{ trans('cruds.userAlert.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item {{ request()->is("password") ? "menu-open" : "" }}">
                        <a href="{{ route('frontend.password') }}" class="nav-link {{ request()->is("password") ? "active" : "" }}">
                            <i class="nav-icon fas fa-key"></i>
                            <p>
                                {{ trans('global.change_password') }}
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
        @endguest
    </div>
</aside>
