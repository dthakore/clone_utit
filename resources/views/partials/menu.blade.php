<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="{{ route("frontend.home") }}" class="brand-link">
        <img src="{{ asset(env('PUXEO_URL').$tenant['logo']) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"/>
        <span class="brand-text font-weight-light">{{ $tenant['app_name']; }} | Puxeo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if (auth()->user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("frontend.home") }}">
                            <i class="fas fa-fw fa-home nav-icon">
                            </i>
                            <p>
                                {{ trans('global.website') }}
                            </p>
                        </a>
                    </li>
                @endif
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/ranks*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }} {{ request()->is("admin/rankRules*") ? "menu-open" : "" }} {{ request()->is("admin/settings/ranks") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('rank_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.settings.ranks") }}" class="nav-link {{ request()->is("admin/ranks/*") || request()->is("admin/rankRules/*") || request()->is("admin/settings/ranks") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-sort-numeric-down">

                                        </i>
                                        <p>
                                            {{ trans('cruds.rank.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('bot_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/exchanges*") ? "menu-open" : "" }} {{ request()->is("admin/user-exchanges*") ? "menu-open" : "" }} {{ request()->is("admin/symbols*") ? "menu-open" : "" }} {{ request()->is("admin/bots*") ? "menu-open" : "" }} {{ request()->is("admin/sessions*") ? "menu-open" : "" }} {{ request()->is("admin/trades*") ? "menu-open" : "" }} {{ request()->is("admin/covers*") ? "menu-open" : "" }} {{ request()->is("admin/exchange-logs*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-robot">

                            </i>
                            <p>
                                {{ trans('cruds.botManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{--@can('exchange_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.exchanges.index") }}" class="nav-link {{ request()->is("admin/exchanges") || request()->is("admin/exchanges/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        {{ trans('cruds.exchange.title') }}
                                    </a>
                                </li>
                            @endcan--}}
                            @can('user_exchange_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.user-exchanges.index") }}" class="nav-link {{ request()->is("admin/user-exchanges") || request()->is("admin/user-exchanges/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chart-line">

                                        </i>
                                        {{ trans('cruds.userExchange.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('symbol_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.symbols.index") }}" class="nav-link {{ request()->is("admin/symbols") || request()->is("admin/symbols/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-dollar-sign">

                                        </i>
                                        {{ trans('cruds.symbol.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('bot_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.bots.index") }}" class="nav-link {{ request()->is("admin/bots") || request()->is("admin/bots/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-robot">

                                        </i>
                                        {{ trans('cruds.bot.title') }}
                                    </a>
                                </li>
                            @endcan
                            {{--@can('session_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.sessions.index") }}" class="nav-link {{ request()->is("admin/sessions") || request()->is("admin/sessions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        {{ trans('cruds.session.title') }}
                                    </a>
                                </li>
                            @endcan--}}
                            @can('trade_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.trades.index") }}" class="nav-link {{ request()->is("admin/trades") || request()->is("admin/trades/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-chart-bar">

                                        </i>
                                        {{ trans('cruds.trade.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('cover_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.covers.index") }}" class="nav-link {{ request()->is("admin/covers") || request()->is("admin/covers/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-bezier-curve">

                                        </i>
                                        {{ trans('cruds.cover.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('exchange_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.exchange-logs.index") }}" class="nav-link {{ request()->is("admin/exchange-logs") || request()->is("admin/exchange-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-exchange-alt">

                                        </i>
                                        {{ trans('cruds.exchangeLog.title') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('system_account_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/user-position-accounts*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users-cog">

                            </i>
                            <p>
                                {{ trans('cruds.systemAccount.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('user_position_account_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.user-position-accounts.index") }}" class="nav-link {{ request()->is("admin/user-position-accounts") || request()->is("admin/user-position-accounts/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.userPositionAccount.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('commission_plan_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/plans*") ? "menu-open" : "" }} {{ request()->is("admin/commission-rules*") ? "menu-open" : "" }} {{ request()->is("admin/commission*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-euro-sign">

                            </i>
                            <p>
                                {{ trans('cruds.commissionPlan.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('plan_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.plans.index") }}" class="nav-link {{ request()->is("admin/plans") || request()->is("admin/plans/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-money-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.plan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('commission_rule_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.commission-rules.index") }}" class="nav-link {{ request()->is("admin/commission-rules") || request()->is("admin/commission-rules/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.commissionRule.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('execute_job_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.commission.index") }}" class="nav-link {{ request()->is("admin/commission") ? "active" : ""}} {{ request()->is("admin/commission/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tasks"></i>
                                        <p>
                                            Execute Job
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('e_commerce_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/products*") ? "menu-open" : "" }} {{ request()->is("admin/product-categories*") ? "menu-open" : "" }} {{ request()->is("admin/product-tags*") ? "menu-open" : "" }} {{ request()->is("admin/orders*") ? "menu-open" : "" }} {{ request()->is("admin/shipment-infos*") ? "menu-open" : "" }} {{ request()->is("admin/order-credit-memos*") ? "menu-open" : "" }} {{ request()->is("admin/payments*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-align-justify">

                            </i>
                            <p>
                                {{ trans('cruds.eCommerce.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('product_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.products.index") }}" class="nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-shopping-cart">

                                        </i>
                                        <p>
                                            {{ trans('cruds.product.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('product_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.product-categories.index") }}" class="nav-link {{ request()->is("admin/product-categories") || request()->is("admin/product-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-folder">

                                        </i>
                                        <p>
                                            {{ trans('cruds.productCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            <!-- @can('product_tag_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.product-tags.index") }}" class="nav-link {{ request()->is("admin/product-tags") || request()->is("admin/product-tags/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
                                        <p>
                                            {{ trans('cruds.productTag.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan -->
                            @can('order_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.orders.index") }}" class="nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-luggage-cart">

                                        </i>
                                        <p>
                                            {{ trans('cruds.order.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            <!-- @can('shipment_info_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.shipment-infos.index") }}" class="nav-link {{ request()->is("admin/shipment-infos") || request()->is("admin/shipment-infos/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-shipping-fast">

                                        </i>
                                        <p>
                                            {{ trans('cruds.shipmentInfo.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan -->
                            @can('payment_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.payments.index") }}" class="nav-link {{ request()->is("admin/payments") || request()->is("admin/payments/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fab fa-amazon-pay">

                                        </i>
                                        <p>
                                            {{ trans('cruds.payment.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('order_credit_memo_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.order-credit-memos.index") }}" class="nav-link {{ request()->is("admin/order-credit-memos") || request()->is("admin/order-credit-memos/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-credit-card">

                                        </i>
                                        <p>
                                            {{ trans('cruds.orderCreditMemo.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('mt_four_manager_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/mt-four-brokers*") ? "menu-open" : "" }} {{ request()->is("admin/cbm-mt-four-accounts*") ? "menu-open" : "" }} {{ request()->is("admin/mt-four-deposit-withdraws*") ? "menu-open" : "" }} {{ request()->is("admin/mt-four-trades*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-ticket-alt">

                            </i>
                            <p>
                                {{ trans('cruds.mtFourManager.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('mt_four_broker_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.mt-four-brokers.index") }}" class="nav-link {{ request()->is("admin/mt-four-brokers") || request()->is("admin/mt-four-brokers/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.mtFourBroker.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('cbm_mt_four_account_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cbm-mt-four-accounts.index") }}" class="nav-link {{ request()->is("admin/cbm-mt-four-accounts") || request()->is("admin/cbm-mt-four-accounts/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.cbmMtFourAccount.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('mt_four_deposit_withdraw_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.mt-four-deposit-withdraws.index") }}" class="nav-link {{ request()->is("admin/mt-four-deposit-withdraws") || request()->is("admin/mt-four-deposit-withdraws/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-book-open">

                                        </i>
                                        <p>
                                            {{ trans('cruds.mtFourDepositWithdraw.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('mt_four_trade_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.mt-four-trades.index") }}" class="nav-link {{ request()->is("admin/mt-four-trades") || request()->is("admin/mt-four-trades/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.mtFourTrade.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('mt_four_vpamm')
                                <li class="nav-item">
                                    <a href="{{ route("admin.vpamm.index") }}" class="nav-link {{ request()->is("admin/vpamm") || request()->is("admin/vpamm/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.vpamm.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('mt_four_daily_balance')
                                <li class="nav-item">
                                    <a href="{{ route("admin.daily-balance.index") }}" class="nav-link {{ request()->is("admin/daily-balance") || request()->is("admin/daily-balance/*") ? "active" : "" }}">
                                            <i class="fa fa-balance-scale"></i>
                                        <p>
                                            {{ trans('cruds.dailyBalance.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route("admin.mam-account.index") }}" class="nav-link {{ request()->is("admin/mam-account") || request()->is("admin/mam-account/*") ? "active" : "" }}">
                                        <i class="fa fa-balance-scale"></i>
                                    <p>
                                        {{ trans('cruds.mamAccount.title') }}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                <li class="nav-item has-treeview {{ request()->is("admin/experts*") ? "menu-open" : "" }} ">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fa-fw nav-icon fas fa-wallet">

                        </i>
                        <p>
                            {{ trans('cruds.followExpert.title') }}
                            <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route("admin.experts.index") }}" class="nav-link {{ request()->is("admin/experts") || request()->is("admin/experts/*") ? "active" : "" }}">
                                    <i class="fa fa-user-shield"></i>

                                <p>
                                    {{ trans('cruds.followExpert.title') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.user-expert-request.index") }}" class="nav-link {{ request()->is("admin/user-expert-request") || request()->is("admin/user-expert-request/*") ? "active" : "" }}">
                                    <i class="fa fa-user-shield"></i>

                                <p>
                                    {{ trans('cruds.userExpertRequest.title') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.user-documents.index") }}" class="nav-link {{ request()->is("admin/user-documents") || request()->is("admin/user-documents/*") ? "active" : "" }}">
                                    <i class="fa fa-user-shield"></i>

                                <p>
                                    {{ trans('cruds.userDocument.title') }}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('wallet_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/denominations*") ? "menu-open" : "" }} {{ request()->is("admin/wallet-meta-types*") ? "menu-open" : "" }} {{ request()->is("admin/wallet-types*") ? "menu-open" : "" }} {{ request()->is("admin/allwallettransactions*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-wallet">

                            </i>
                            <p>
                                {{ trans('cruds.walletManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('denomination_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.denominations.index") }}" class="nav-link {{ request()->is("admin/denominations") || request()->is("admin/denominations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-receipt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.denomination.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('wallet_meta_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.wallet-meta-types.index") }}" class="nav-link {{ request()->is("admin/wallet-meta-types") || request()->is("admin/wallet-meta-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-piggy-bank">

                                        </i>
                                        <p>
                                            {{ trans('cruds.walletMetaType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('wallet_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.wallet-types.index") }}" class="nav-link {{ request()->is("admin/wallet-types") || request()->is("admin/wallet-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-money-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.walletType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('allwallettransaction_access')
                                    <li class="nav-item">
                                        <a href="{{ route("admin.allwallettransactions.userwallet") }}" class="nav-link {{ request()->is("admin/allwallettransactions/userwallet") || request()->is("admin/allwallettransactions/userwallet") ? "active" : "" }}">
                                            <i class="fa-fw nav-icon fas fa-wallet">

                                            </i>
                                            <p>
                                                {{ trans('cruds.userwallet.title') }}
                                            </p>
                                        </a>
                                    </li>
                                <li class="nav-item">
                                    <a href="{{ route("admin.allwallettransactions.index") }}" class="nav-link {{ request()->is("admin/allwallettransactions") || request()->is("admin/allwallettransactions") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-wallet">

                                        </i>
                                        <p>
                                            {{ trans('cruds.allwallettransaction.title') }}
                                        </p>
                                    </a>
                                </li>

                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('faq_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/faq-categories*") ? "menu-open" : "" }} {{ request()->is("admin/faq-questions*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-question">

                            </i>
                            <p>
                                {{ trans('cruds.faqManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('faq_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.faq-categories.index") }}" class="nav-link {{ request()->is("admin/faq-categories") || request()->is("admin/faq-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.faqCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('faq_question_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.faq-questions.index") }}" class="nav-link {{ request()->is("admin/faq-questions") || request()->is("admin/faq-questions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-question">

                                        </i>
                                        <p>
                                            {{ trans('cruds.faqQuestion.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('contact_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/contact-companies*") ? "menu-open" : "" }} {{ request()->is("admin/contact-contacts*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-phone-square">

                            </i>
                            <p>
                                {{ trans('cruds.contactManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('contact_company_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.contact-companies.index") }}" class="nav-link {{ request()->is("admin/contact-companies") || request()->is("admin/contact-companies/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-building">

                                        </i>
                                        <p>
                                            {{ trans('cruds.contactCompany.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('contact_contact_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.contact-contacts.index") }}" class="nav-link {{ request()->is("admin/contact-contacts") || request()->is("admin/contact-contacts/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-plus">

                                        </i>
                                        <p>
                                            {{ trans('cruds.contactContact.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('courses_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/courses*") ? "menu-open" : "" }} {{ request()->is("admin/lessons*") ? "menu-open" : "" }} {{ request()->is("admin/tests*") ? "menu-open" : "" }} {{ request()->is("admin/questions*") ? "menu-open" : "" }} {{ request()->is("admin/question-options*") ? "menu-open" : "" }} {{ request()->is("admin/test-results*") ? "menu-open" : "" }} {{ request()->is("admin/test-answers*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-book">

                            </i>
                            <p>
                                {{ trans('cruds.coursesManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('course_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.courses.index") }}" class="nav-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-graduation-cap">

                                        </i>
                                        <p>
                                            {{ trans('cruds.course.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('lesson_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.lessons.index") }}" class="nav-link {{ request()->is("admin/lessons") || request()->is("admin/lessons/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-book-reader">

                                        </i>
                                        <p>
                                            {{ trans('cruds.lesson.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('test_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.tests.index") }}" class="nav-link {{ request()->is("admin/tests") || request()->is("admin/tests/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-microscope">

                                        </i>
                                        <p>
                                            {{ trans('cruds.test.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('question_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.questions.index") }}" class="nav-link {{ request()->is("admin/questions") || request()->is("admin/questions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-question">

                                        </i>
                                        <p>
                                            {{ trans('cruds.question.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('question_option_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.question-options.index") }}" class="nav-link {{ request()->is("admin/question-options") || request()->is("admin/question-options/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chalkboard">

                                        </i>
                                        <p>
                                            {{ trans('cruds.questionOption.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('test_result_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.test-results.index") }}" class="nav-link {{ request()->is("admin/test-results") || request()->is("admin/test-results/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file">

                                        </i>
                                        <p>
                                            {{ trans('cruds.testResult.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('test_answer_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.test-answers.index") }}" class="nav-link {{ request()->is("admin/test-answers") || request()->is("admin/test-answers/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.testAnswer.title') }}
                                        </p>
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
                @can('country_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.countries.index") }}" class="nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-flag">

                            </i>
                            <p>
                                {{ trans('cruds.country.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @php($unread = \App\Models\QaTopic::unreadCount())
                    <li class="nav-item">
                        <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "active" : "" }} nav-link">
                            <i class="fa-fw fa fa-envelope nav-icon">

                            </i>
                            <p>{{ trans('global.messages') }}</p>
                            @if($unread > 0)
                                <strong>( {{ $unread }} )</strong>
                            @endif

                        </a>
                    </li>
                    @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                        @can('profile_password_edit')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                    <i class="fa-fw fas fa-key nav-icon">
                                    </i>
                                    <p>
                                        {{ trans('global.change_password') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <p>
                                <i class="fas fa-fw fa-sign-out-alt nav-icon">

                                </i>
                                <p>{{ trans('global.logout') }}</p>
                            </p>
                        </a>
                    </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
