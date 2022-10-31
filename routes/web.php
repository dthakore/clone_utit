<?php
Route::get('/',function () {

    if (auth()->check()) {
        return \redirect('/home');
    }

z    //return view('down');
});
// Route::get('/', 'HomeController@index')->name('home');
Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Route::get('resendVerification', 'UserVerificationController@resendVerification')->name('resendVerification');
Route::post('resendVerification', 'UserVerificationController@resendVerificationSubmit')->name('resendVerificationSubmit');
//Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// Route::get('register', function () {
//     return abort(404);
// });
//Route::group(['domain' => 'utradeitrade.com'], function () {
    //Route::get('/{id}', 'Auth\RegisterController@showRegistrationForm')->where('id', '[0-9]+');
    //Route::post('register/{id}', 'Auth\RegisterController@register');
//});
Route::get('upgrade_license/{id}', 'UpgradeLicenseController@checkout');
Route::post('upgrade_license/submit', 'UpgradeLicenseController@store');
Route::get('upgrade_license/success/{id}', 'UpgradeLicenseController@show');
Route::group(['as' => 'frontend.','domain' => 'cashback.utradeitrade.com', 'namespace' => 'Frontend'], function () {
    Route::get('/{id}', 'UserPositionAccountsController@accountData')->name('account');
    Route::get('/cb_home/{id}', 'HomeController@indexCashback')->name('indexCashback');
    Route::get('/geneology/{id}', 'HomeController@geneologyCashBack')->name('cb_geneology');
});
Route::group(['namespace' => 'sio'], function () {
    // SIO
    Route::get('/{id}', 'RegisterController@showVerifyEmailForm')->where('id', '[0-9]+');
    Route::post('sio/verify/email', 'RegisterController@verifyEmail')->name('sio.verify.email');
    Route::get('sio/register', 'RegisterController@register')->name('sio.register');
    Route::post('sio/register/user', 'RegisterController@registerUser')->name('sio.register.user');
    Route::get('sio/activation', 'RegisterController@accountActivation')->name('sio.activation');
    Route::get('sio/autologin', 'LoginController@sioLogin')->name('sioLogin');
    Route::get('sio/login', 'LoginController@loginPage')->name('sio.login');
    Route::post('sio/logout', 'LoginController@sioLogout')->name('sio.logout');
});
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa', 'admin']], function () {
    Route::get('invoice/{id}','OrdersController@generateInvoice');

    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('experts', 'FollowExpertController');
    Route::resource('user-expert-request', 'UserExpertRequestController');
    Route::post('experts/media', 'FollowExpertController@storeMedia')->name('experts.storeMedia');
    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::get('users/tree-view', 'UsersController@treeView')->name('users.treeView');
    Route::get('users/tree/{id}', 'UsersController@tree')->name('users.tree');
    Route::get('/users/login/{id}', 'UsersController@autoLogin')->name('users.login');
    Route::get('/users/stop', 'UsersController@stopAutoLogin');
    Route::resource('users', 'UsersController');


    // User Document
    Route::resource('user-documents', 'UserDocumentController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController');

    // Denominations
    Route::delete('denominations/destroy', 'DenominationsController@massDestroy')->name('denominations.massDestroy');
    Route::resource('denominations', 'DenominationsController');

    // Wallet Meta Types
    Route::delete('wallet-meta-types/destroy', 'WalletMetaTypesController@massDestroy')->name('wallet-meta-types.massDestroy');
    Route::resource('wallet-meta-types', 'WalletMetaTypesController');

    // Wallet Types
    Route::delete('wallet-types/destroy', 'WalletTypesController@massDestroy')->name('wallet-types.massDestroy');
    Route::resource('wallet-types', 'WalletTypesController');

    // Allwallettransactions
    Route::delete('allwallettransactions/destroy', 'AllwallettransactionsController@massDestroy')->name('allwallettransactions.massDestroy');
    Route::post('allwallettransactions/parse-csv-import', 'AllwallettransactionsController@parseCsvImport')->name('allwallettransactions.parseCsvImport');
    Route::post('allwallettransactions/process-csv-import', 'AllwallettransactionsController@processCsvImport')->name('allwallettransactions.processCsvImport');
    Route::any('allwallettransactions/userwallet', 'AllwallettransactionsController@userWallet')->name('allwallettransactions.userwallet');
    Route::resource('allwallettransactions', 'AllwallettransactionsController');

    // Orders
    Route::delete('orders/destroy', 'OrdersController@massDestroy')->name('orders.massDestroy');
    Route::post('orders/parse-csv-import', 'OrdersController@parseCsvImport')->name('orders.parseCsvImport');
    Route::post('orders/process-csv-import', 'OrdersController@processCsvImport')->name('orders.processCsvImport');
    Route::resource('orders', 'OrdersController');
    Route::post('load-price', 'OrdersController@loadPrice');
    Route::post('get-address', 'OrdersController@getAddress');

    // Cbm Mt Four Accounts
    Route::post('cbm-mt-four-accounts/parse-csv-import', 'CbmMtFourAccountsController@parseCsvImport')->name('cbm-mt-four-accounts.parseCsvImport');
    Route::post('cbm-mt-four-accounts/process-csv-import', 'CbmMtFourAccountsController@processCsvImport')->name('cbm-mt-four-accounts.processCsvImport');
    Route::resource('cbm-mt-four-accounts', 'CbmMtFourAccountsController', ['except' => ['edit', 'update', 'destroy']]);

    // Countries
    Route::resource('countries', 'CountriesController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Shipment Info
    Route::delete('shipment-infos/destroy', 'ShipmentInfoController@massDestroy')->name('shipment-infos.massDestroy');
    Route::resource('shipment-infos', 'ShipmentInfoController');

    // Order Credit Memo
    Route::delete('order-credit-memos/destroy', 'OrderCreditMemoController@massDestroy')->name('order-credit-memos.massDestroy');
    Route::resource('order-credit-memos', 'OrderCreditMemoController', ['except' => ['create', 'store', 'edit', 'update']]);

    // Mt Four Brokers
    Route::delete('mt-four-brokers/destroy', 'MtFourBrokersController@massDestroy')->name('mt-four-brokers.massDestroy');
    Route::resource('mt-four-brokers', 'MtFourBrokersController');

    // User Position Accounts
    Route::post('user-position-accounts/parse-csv-import', 'UserPositionAccountsController@parseCsvImport')->name('user-position-accounts.parseCsvImport');
    Route::post('user-position-accounts/process-csv-import', 'UserPositionAccountsController@processCsvImport')->name('user-position-accounts.processCsvImport');
    Route::resource('user-position-accounts', 'UserPositionAccountsController', ['except' => ['edit', 'update', 'show', 'destroy']]);

    // Mt Four Deposit Withdraw
    Route::post('mt-four-deposit-withdraws/parse-csv-import', 'MtFourDepositWithdrawController@parseCsvImport')->name('mt-four-deposit-withdraws.parseCsvImport');
    Route::post('mt-four-deposit-withdraws/process-csv-import', 'MtFourDepositWithdrawController@processCsvImport')->name('mt-four-deposit-withdraws.processCsvImport');
    Route::resource('mt-four-deposit-withdraws', 'MtFourDepositWithdrawController', ['except' => ['edit', 'update', 'destroy']]);

    // Mt Four Trades
    Route::delete('mt-four-trades/destroy', 'MtFourTradesController@massDestroy')->name('mt-four-trades.massDestroy');
    Route::resource('mt-four-trades', 'MtFourTradesController', ['except' => ['create', 'store', 'edit', 'update']]);

    // Mt Four VPAMM
    Route::get('vpamm', 'MtFourVPAMMController@index')->name('vpamm.index');
    Route::post('importApidata', 'MtFourVPAMMController@importApidata')->name('importApidata');

    // Mt Four Daily Balance
    Route::get('daily-balance', 'MtFourDailyBalanceController@index')->name('daily-balance.index');

    // Mt Four Mam Accounts
    Route::resource('mam-account', 'MtFourMamAccountController');


    // Plans
    Route::delete('plans/destroy', 'PlansController@massDestroy')->name('plans.massDestroy');
    Route::post('plans/media', 'PlansController@storeMedia')->name('plans.storeMedia');
    Route::post('plans/ckmedia', 'PlansController@storeCKEditorImages')->name('plans.storeCKEditorImages');
    Route::resource('plans', 'PlansController');

    // Commission Rules
    Route::delete('commission-rules/destroy', 'CommissionRulesController@massDestroy')->name('commission-rules.massDestroy');
    Route::resource('commission-rules', 'CommissionRulesController');

    // Ranks
    Route::delete('ranks/destroy', 'RanksController@massDestroy')->name('ranks.massDestroy');
    Route::post('ranks/media', 'RanksController@storeMedia')->name('ranks.storeMedia');
    Route::post('ranks/ckmedia', 'RanksController@storeCKEditorImages')->name('ranks.storeCKEditorImages');
    Route::resource('ranks', 'RanksController');
    Route::post('compute-rank', 'RanksController@computeRank');
    Route::get('settings/ranks', 'RanksController@settings')->name('settings.ranks');

    // Rank Rules
    Route::delete('rankRules/destroy', 'RankRulesController@massDestroy')->name('rankRules.massDestroy');
    Route::resource('rankRules', 'RankRulesController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Faq Category
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq Question
    Route::delete('faq-questions/destroy', 'FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::resource('faq-questions', 'FaqQuestionController');

    // Contact Company
    Route::delete('contact-companies/destroy', 'ContactCompanyController@massDestroy')->name('contact-companies.massDestroy');
    Route::resource('contact-companies', 'ContactCompanyController');

    // Contact Contacts
    Route::delete('contact-contacts/destroy', 'ContactContactsController@massDestroy')->name('contact-contacts.massDestroy');
    Route::resource('contact-contacts', 'ContactContactsController');

    // Courses
    Route::delete('courses/destroy', 'CoursesController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CoursesController@storeMedia')->name('courses.storeMedia');
    Route::post('courses/ckmedia', 'CoursesController@storeCKEditorImages')->name('courses.storeCKEditorImages');
    Route::resource('courses', 'CoursesController');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::post('lessons/media', 'LessonsController@storeMedia')->name('lessons.storeMedia');
    Route::post('lessons/ckmedia', 'LessonsController@storeCKEditorImages')->name('lessons.storeCKEditorImages');
    Route::resource('lessons', 'LessonsController');

    // export
    Route::post('/cbm-mt-four-accounts-export', 'CbmMtFourAccountsController@exportTransaction')->name('cbmMt4AccountsExport');

    // Tests
    Route::delete('tests/destroy', 'TestsController@massDestroy')->name('tests.massDestroy');
    Route::resource('tests', 'TestsController');

    // Questions
    Route::delete('questions/destroy', 'QuestionsController@massDestroy')->name('questions.massDestroy');
    Route::post('questions/media', 'QuestionsController@storeMedia')->name('questions.storeMedia');
    Route::post('questions/ckmedia', 'QuestionsController@storeCKEditorImages')->name('questions.storeCKEditorImages');
    Route::resource('questions', 'QuestionsController');

    // Question Options
    Route::delete('question-options/destroy', 'QuestionOptionsController@massDestroy')->name('question-options.massDestroy');
    Route::resource('question-options', 'QuestionOptionsController');

    // Test Results
    Route::delete('test-results/destroy', 'TestResultsController@massDestroy')->name('test-results.massDestroy');
    Route::resource('test-results', 'TestResultsController');

    // Test Answers
    Route::delete('test-answers/destroy', 'TestAnswersController@massDestroy')->name('test-answers.massDestroy');
    Route::resource('test-answers', 'TestAnswersController');

     // Exchange Logs
     Route::delete('exchange-logs/destroy', 'ExchangeLogsController@massDestroy')->name('exchange-logs.massDestroy');
     Route::resource('exchange-logs', 'ExchangeLogsController', ['except' => ['create', 'store', 'edit', 'update']]);

    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');

    // Exchanges
    Route::delete('exchanges/destroy', 'ExchangesController@massDestroy')->name('exchanges.massDestroy');
    Route::post('exchanges/media', 'ExchangesController@storeMedia')->name('exchanges.storeMedia');
    Route::post('exchanges/ckmedia', 'ExchangesController@storeCKEditorImages')->name('exchanges.storeCKEditorImages');
    Route::resource('exchanges', 'ExchangesController');

    // User Exchanges
    Route::delete('user-exchanges/destroy', 'UserExchangesController@massDestroy')->name('user-exchanges.massDestroy');
    Route::resource('user-exchanges', 'UserExchangesController');

    // Symbols
    Route::resource('symbols', 'SymbolsController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Bots
    Route::delete('bots/destroy', 'BotsController@massDestroy')->name('bots.massDestroy');
    Route::resource('bots', 'BotsController');

    // Sessions
    Route::resource('sessions', 'SessionsController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Trades
    Route::delete('trades/destroy', 'TradesController@massDestroy')->name('trades.massDestroy');
    Route::resource('trades', 'TradesController');

    // Covers
    Route::delete('covers/destroy', 'CoversController@massDestroy')->name('covers.massDestroy');
    Route::resource('covers', 'CoversController', ['except' => ['show']]);

    // Payment
    Route::delete('payments/destroy', 'PaymentController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentController');

    //commission
    Route::get('commission', 'CommissionController@index')->name('commission.index');
    Route::post('commission/distribute', 'CommissionController@distributeCommission')->name('commission.distribute');
    Route::post('all/trades', 'CommissionController@allTrades')->name('all.trades');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa','auto.login']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth', '2fa','auto.login']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::any('/cb_logout', 'HomeController@logout')->name('cb_logout');
    Route::get('/affiliate-center', 'HomeController@affiliate')->name('affiliate');
    Route::get('/new_home', function () {
        return view('frontend.test');
    });
    Route::get('contacts',function () { return view('frontend.contact'); })->name('contacts');
    Route::get('contact-us',function () { return view('frontend.contact-us'); })->name('contact-us');
    Route::get('faq',function () { return view('frontend.faq'); })->name('faq');

    //Product Page
    Route::get('shop', 'ProductController@list')->name('shop');
    Route::post('product/getLicenseId', 'ProductController@GetLicenseId')->name('LicenseId');
    Route::post('product/getLicensePrice', 'ProductController@GetLicensePrice')->name('LicensePrice');
    Route::get('my-orders', 'OrdersController@list')->name('order');
    Route::get('order/{id}', 'OrdersController@detail');
    Route::get('product/{id}', 'ProductController@index');
    Route::get('checkout', 'OrdersController@checkout')->name('order.billing');;
    Route::get('add-cart/{id}', 'OrdersController@addCart')->name('AddCart');;
    Route::post('delete-cart', 'OrdersController@deleteCart')->name('cart.delete');;
    Route::post('update-cart', 'OrdersController@updateCart')->name('cart.update');;
    Route::get('cart', 'OrdersController@cart')->name('order.cart');;
    Route::post('submit', 'OrdersController@store')->name('order.submit');
    Route::get('success/{id}', 'OrdersController@show');
    Route::get('invoice/{id}','OrdersController@generateInvoice');
    Route::get('license/{order_id}/{product_id}/{user_id}','OrdersController@generateLicense');

//    Route::get('product',function () { return view('frontend.products.index'); })->name('product');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // My Documents
    Route::get('my-documents', 'UserDocumentController@list')->name('documents');
    Route::post('my-documents/store', 'UserDocumentController@updateStore')->name('document.store');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');


    //Stripe Payment
    Route::get('/stripe', 'StripeController@index');
    Route::post('/stripe_pay', 'StripeController@pay')->name('stripe.post');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Denominations
    Route::delete('denominations/destroy', 'DenominationsController@massDestroy')->name('denominations.massDestroy');
    Route::resource('denominations', 'DenominationsController');

    // Wallet Meta Types
    Route::delete('wallet-meta-types/destroy', 'WalletMetaTypesController@massDestroy')->name('wallet-meta-types.massDestroy');
    Route::resource('wallet-meta-types', 'WalletMetaTypesController');

    // Wallet Types
    Route::delete('wallet-types/destroy', 'WalletTypesController@massDestroy')->name('wallet-types.massDestroy');
    Route::resource('wallet-types', 'WalletTypesController');

    // Allwallettransactions
    Route::delete('allwallettransactions/destroy', 'AllwallettransactionsController@massDestroy')->name('allwallettransactions.massDestroy');
    Route::resource('allwallettransactions', 'AllwallettransactionsController');
//    Route::get('wallet', 'AllwallettransactionsController@wallet')->name('wallet');
    Route::post('add/funds', 'AllwallettransactionsController@addFundsToWallet')->name('add.funds');

    // License
    Route::get('license', 'OrdersController@license')->name('license');


    // Orders
    Route::delete('orders/destroy', 'OrdersController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrdersController');

    // Cbm Mt Four Accounts
    Route::resource('cbm-mt-four-accounts', 'CbmMtFourAccountsController', ['except' => ['edit', 'update', 'destroy']]);

    // Countries
    Route::resource('countries', 'CountriesController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Shipment Info
    Route::delete('shipment-infos/destroy', 'ShipmentInfoController@massDestroy')->name('shipment-infos.massDestroy');
    Route::resource('shipment-infos', 'ShipmentInfoController');

    // Order Credit Memo
    Route::delete('order-credit-memos/destroy', 'OrderCreditMemoController@massDestroy')->name('order-credit-memos.massDestroy');
    Route::resource('order-credit-memos', 'OrderCreditMemoController', ['except' => ['create', 'store', 'edit', 'update']]);

    // Mt Four Brokers
    Route::delete('mt-four-brokers/destroy', 'MtFourBrokersController@massDestroy')->name('mt-four-brokers.massDestroy');
    Route::resource('mt-four-brokers', 'MtFourBrokersController');

    // User Position Accounts
    Route::resource('user-position-accounts', 'UserPositionAccountsController', ['except' => ['edit', 'update', 'show', 'destroy']]);
//    Route::get('account', 'UserPositionAccountsController@accountData')->name('account');


    // Mt Four Deposit Withdraw
    Route::resource('mt-four-deposit-withdraws', 'MtFourDepositWithdrawController', ['except' => ['edit', 'update', 'destroy']]);

    // Mt Four Trades
    Route::delete('mt-four-trades/destroy', 'MtFourTradesController@massDestroy')->name('mt-four-trades.massDestroy');
    Route::resource('mt-four-trades', 'MtFourTradesController', ['except' => ['create', 'store', 'edit', 'update']]);

    // Plans
    Route::delete('plans/destroy', 'PlansController@massDestroy')->name('plans.massDestroy');
    Route::post('plans/media', 'PlansController@storeMedia')->name('plans.storeMedia');
    Route::post('plans/ckmedia', 'PlansController@storeCKEditorImages')->name('plans.storeCKEditorImages');
    Route::resource('plans', 'PlansController');

    // Commission Rules
    Route::delete('commission-rules/destroy', 'CommissionRulesController@massDestroy')->name('commission-rules.massDestroy');
    Route::resource('commission-rules', 'CommissionRulesController');

    // Ranks
    Route::delete('ranks/destroy', 'RanksController@massDestroy')->name('ranks.massDestroy');
    Route::post('ranks/media', 'RanksController@storeMedia')->name('ranks.storeMedia');
    Route::post('ranks/ckmedia', 'RanksController@storeCKEditorImages')->name('ranks.storeCKEditorImages');
    Route::resource('ranks', 'RanksController');

    // Faq Category
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq Question
    Route::delete('faq-questions/destroy', 'FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::resource('faq-questions', 'FaqQuestionController');

    // Contact Company
    Route::delete('contact-companies/destroy', 'ContactCompanyController@massDestroy')->name('contact-companies.massDestroy');
    Route::resource('contact-companies', 'ContactCompanyController');

    // Contact Contacts
    Route::delete('contact-contacts/destroy', 'ContactContactsController@massDestroy')->name('contact-contacts.massDestroy');
    Route::resource('contact-contacts', 'ContactContactsController');

    // Follow Expert
    Route::get('experts', 'FollowExpertController@index')->name('expert');
    Route::post('user-request', 'FollowExpertController@getUserRequest')->name('user-request.post');

    // Courses
    Route::delete('courses/destroy', 'CoursesController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CoursesController@storeMedia')->name('courses.storeMedia');
    Route::post('courses/ckmedia', 'CoursesController@storeCKEditorImages')->name('courses.storeCKEditorImages');
    Route::resource('courses', 'CoursesController');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::post('lessons/media', 'LessonsController@storeMedia')->name('lessons.storeMedia');
    Route::post('lessons/ckmedia', 'LessonsController@storeCKEditorImages')->name('lessons.storeCKEditorImages');
    Route::resource('lessons', 'LessonsController');

    // Tests
    Route::delete('tests/destroy', 'TestsController@massDestroy')->name('tests.massDestroy');
    Route::resource('tests', 'TestsController');

    // Questions
    Route::delete('questions/destroy', 'QuestionsController@massDestroy')->name('questions.massDestroy');
    Route::post('questions/media', 'QuestionsController@storeMedia')->name('questions.storeMedia');
    Route::post('questions/ckmedia', 'QuestionsController@storeCKEditorImages')->name('questions.storeCKEditorImages');
    Route::resource('questions', 'QuestionsController');

    // Question Options
    Route::delete('question-options/destroy', 'QuestionOptionsController@massDestroy')->name('question-options.massDestroy');
    Route::resource('question-options', 'QuestionOptionsController');

    // Test Results
    Route::delete('test-results/destroy', 'TestResultsController@massDestroy')->name('test-results.massDestroy');
    Route::resource('test-results', 'TestResultsController');

    // Test Answers
    Route::delete('test-answers/destroy', 'TestAnswersController@massDestroy')->name('test-answers.massDestroy');
    Route::resource('test-answers', 'TestAnswersController');

    // Exchanges
    Route::delete('exchanges/destroy', 'ExchangesController@massDestroy')->name('exchanges.massDestroy');
    Route::post('exchanges/media', 'ExchangesController@storeMedia')->name('exchanges.storeMedia');
    Route::post('exchanges/ckmedia', 'ExchangesController@storeCKEditorImages')->name('exchanges.storeCKEditorImages');
    Route::resource('exchanges', 'ExchangesController');

    // User Exchanges
    Route::delete('user-exchanges/destroy', 'UserExchangesController@massDestroy')->name('user-exchanges.massDestroy');
    Route::resource('user-exchanges', 'UserExchangesController');

    // Symbols
    Route::resource('symbols', 'SymbolsController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Bots
    /*Route::delete('bots/destroy', 'BotsController@massDestroy')->name('bots.massDestroy');
    Route::resource('bots', 'BotsController');*/

    // Sessions
    Route::resource('sessions', 'SessionsController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Trades
    /*Route::delete('trades/destroy', 'TradesController@massDestroy')->name('trades.massDestroy');
    Route::resource('trades', 'TradesController');*/

    // Covers
    /*Route::delete('covers/destroy', 'CoversController@massDestroy')->name('covers.massDestroy');
    Route::resource('covers', 'CoversController', ['except' => ['show']]);*/

    // Payment
    Route::delete('payments/destroy', 'PaymentController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentController');

    // Radial
    Route::get('radial', 'RadialController@index')->name('radial.index');
    Route::post('radial/matrixData', 'RadialController@matrixData')->name('radial.matrixData');
    Route::post('radial/allNode', 'RadialController@allNode')->name('radial.allNode');
    Route::post('radial/goToParent', 'RadialController@goToParent')->name('radial.goToParent');
    Route::post('radial/calculateNodeChild', 'RadialController@calculateNodeChild')->name('radial.calculateNodeChild');

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('password', 'ProfileController@changePassword')->name('password');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/toggle-two-factor', 'ProfileController@toggleTwoFactor')->name('profile.toggle-two-factor');
    Route::post('profile/upgrade-platform', 'OrdersController@addTradingInCart')->name('profile.upgrade-platform');
    Route::get('/bot-api/bots', 'ApiController@index')->name('api.bots');
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});


