<?php

// Route::post('/login-with-otp/', 'LoginController@loginWithOTP')->name('login.withotp');
Route::get('/otp-login/{user_id}', 'Auth\LoginController@addLoginOTP')->name('login.addotp');
Route::get('/resend-login-otp/{user_id}', 'Auth\LoginController@resendLoginOTP')->name('login.resendloginotp');
Route::post('/verify-login-otp', 'Auth\LoginController@verifyLoginOTP')->name('login.verifyotp');


Route::get('/auto-match/{id}', 'AutoConnectionController@sendAutoMatchRequests');
Route::get('/match-request/{authUserId}/{userId}', 'AutoConnectionController@viewAutoMatchRequest')->name('view.automatch');
Route::get('/match-details/{authUserId}/{userId}', 'AutoConnectionController@matchDetails')->name('matchdetails.automatch');
// Route::get('/realtor-details/{authUserId}/{userId}', 'AutoConnectionController@realtorDetails')->name('realtordetails.automatch');
Route::post('/match-request/{authUserId}/{userId}', 'AutoConnectionController@requestAutoMatch')->name('create.automatch');


Route::get('/sample-email/{id}', 'Pub\Users\UsersController@testEmailSample');
Route::get('/send-otp/{id}', 'Auth\VerifyMobileController@sendOTPToVerifyMobile')->name('otp.sendnewotp');
Route::get('/verify-otp/{id}', 'Auth\VerifyMobileController@verifyTestOTP')->name('verify.phone');
Route::post('/verify-otp', 'Auth\VerifyMobileController@verifyOTP')->name('verify.otp');
Route::get('/resend-otp/{id}', 'Auth\VerifyMobileController@reSendNewOTP')->name('resend.otp');


Route::get('/social-reviews', 'Pub\SocialReviewsController@getSocialReviews')->name('socialreviews');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', function() {
    return redirect()->route('home');
});
Route::get('/sell-property', 'Pub\PropertyController@sellPropertyForm')->name('property.sell');
Route::get('/buy-property', 'Pub\PropertyController@buyPropertyForm')->name('property.buy');
Route::post('/submit-property-form', 'Pub\PropertyController@store')->name('property.store');
Route::get('/refinance-quote', 'Pub\RefinanceController@index')->name('refinance.home-loan');
Route::post('/refinance-quote', 'Pub\RefinanceController@store')->name('refinance.store');
Route::get('/thank-you', 'Pub\RefinanceController@indexThankyouPage')->name('lead-form.thankyou');
Route::get('/password/request-new-password', 'SetPasswordController@index')->name('requestPasswordView');
Route::post('/password/request-new-password', 'SetPasswordController@postEmail')->name('postEmail');

Route::get('/password/set-new-password/{token}', 'SetPasswordController@getPassword')->name('getPassword');
Route::post('/password/set-new-password', 'SetPasswordController@updatePassword')->name('updatePassword');

//Route::get('/connect', function() {
//	return view('connect');
//});
Auth::routes();

// Braintree webhook controller
Route::post(
	'/braintree/webhook',
	'WebhookController@handleWebhook'
);

Route::get('/register/verify/{token}','Auth\VerifyEmailController@verify')->name('auth.email-verification');
Route::middleware('auth')->post('/register/verify/re-send', 'Auth\VerifyEmailController@resendVerification')->name('auth.resend-email-verification');
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');


//Route::get('/register/realtor', 'Auth\RealtorRegisterController@showRegistrationForm')->name('register-realtor');
//Route::post('/register/realtor', 'Auth\RealtorRegisterController@register')->name('register-realtor-process');
//Route::middleware('auth')->get('/register/realtor-step-2', 'Auth\RealtorRegisterController@step2')->name('realtor-step-2');
//Route::middleware('auth')->post('/register/realtor-step-2', 'Auth\RealtorRegisterController@step2Process')->name('realtor-step-2-process');

//Route::get('/register/lender', 'Auth\LenderRegisterController@showRegistrationForm')->name('register-lender');
//Route::post('/register/lender', 'Auth\LenderRegisterController@register')->name('register-lender-process');
//Route::middleware('auth')->get('/register/broker-step-2', 'Auth\LenderRegisterController@step2')->name('broker-step-2');
//Route::middleware('auth')->post('/register/broker-step-2', 'Auth\LenderRegisterController@step2Process')->name('broker-step-2-process');


// Unauthenticated Routes
Route::group([
	'namespace' => 'Pub',
//	'middleware' => ['require_login']
],
	function() {
		Route::get('/user/{user_id}', 'Users\UsersController@show')
            ->name('pub.user.show');

	}
);

Route::get('/faq', 'Pub\FaqController@index')->name('pub.faq.index');
Route::get('/about', 'Pub\AboutController@index')->name('pub.about.index');
Route::get('/search-profiles', 'Pub\ConnectController@index')->name('pub.connect.index');

Route::get('/search-lender-profiles', 'Pub\ConnectController@lenderProfiles')->name('pub.connect.lenderProfiles');
Route::get('/search-realtor-profiles', 'Pub\ConnectController@realtorProfiles')->name('pub.connect.realtorProfiles');
Route::get('/search-vendor-profiles', 'Pub\ConnectController@vendorProfiles')->name('pub.connect.vendorProfiles');

Route::get('/search-vendor', 'Pub\ConnectController@searchProfile')->name('pub.connect.searchVendorProfile');
Route::match(['POST', 'GET'], '/check-vendor-category', 'Pub\ConnectController@fetchVendorCategory')->name('profile.connect.fetchCategoryBasedVendor');
Route::get('/vendor-category/{slug}','Pub\ConnectController@fetchVendorCategoryUsers')->name('pub.connect.fetchCatUsers');

Route::get('/realtor-register', 'Auth\RegisterController@showRealtorRegistrationForm')->name('realtor-register');
Route::get('/lender-register', 'Auth\RegisterController@showLenderRegistrationForm')->name('lender-register');
Route::get('/contact', 'Pub\ContactController@index')->name('pub.contact.index');
Route::get('/advertise-on-real-broker-connection!', 'Pub\ContactController@advertise')->name('pub.contact.advertise');
Route::get('/register-today!', 'Pub\ContactController@registerToday')->name('pub.contact.registerToday');
Route::post('/contact', 'Pub\ContactController@send')->name('pub.contact.send');
Route::get('/terms-and-conditions', 'Pub\TermsAndConditionsController@index')->name('pub.terms-and-conditions.index');
Route::get('/privacy-policy', 'Pub\PrivacyPolicyController@index')->name('pub.privacy-policy.index');

Route::get('/subscription-required', function() {
	return view('pub.subscribe-now.index');
})->name('pub.subscribe-now.index');

Route::get('/unsubscribe', 'UnsubscribeController@index')->name('unsubscribe.index');

Route::get('/review/{user_id}', 'Pub\ReviewsController@UserIndex')->name('pub.reviews.others');

Route::get('/mortgage-blog', 'Pub\BlogsController@lendersindex')->name('lendersBlogListing');
Route::get('/real-estate-blog', 'Pub\BlogsController@aganetsindex')->name('agentsBlogListing');
Route::get('/blog', 'Pub\BlogsController@index')->name('blogListing');
Route::get('/mortgage-blog/{title}', 'Pub\BlogsController@viewBlog')->name('lenderBlogView');
Route::get('/real-estate-blog/{title}', 'Pub\BlogsController@viewBlog')->name('agentBlogView');

// Short URl Route
Route::get('/r/{short_url}', 'Pub\RedirectLinkController@redirectLink')->name('redirect.link');


// Authenticated Routes
Route::group([
		'namespace' => 'Pub',
		// 'middleware' => ['auth','isMobileVerified'],
		'middleware' => ['auth'],
		'as' => 'pub.',
	],
	function() {
		// Profile Routes
		Route::get('/profile/manage-social-reviews', 'Profile\ProfileSocailReviewsController@index')->name('profile.profileSocialReviews');
		
        Route::get('/profile/leads/property', 'Profile\LeadsController@indexPropertyLead')->name('profile.leads.property');
		Route::get('/profile/leads/property/view/{lead_id}', 'Profile\LeadsController@viewPropertyLead')->name('profile.leads.property.view');

        Route::get('/profile/leads/refinance', 'Profile\LeadsController@indexRefinanceLeads')->name('profile.leads.refinance');
		Route::get('/profile/leads/refinance/view/{lead_id}', 'Profile\LeadsController@viewRefinanceLead')->name('profile.leads.refinance.view');

		Route::match(['PUT', 'PATCH'], '/profile/manage-social-reviews', 'Profile\ProfileSocailReviewsController@update')->name('profile.profileSocialReviews.update');
		
		Route::get('/profile', 'Profile\DashboardController@index')->name('profile.index');

		// Edit basic profile information
		Route::get('/profile/detail', 'Profile\DetailController@index')->name('profile.detail.edit');
		Route::match(['PUT', 'PATCH'], '/profile/detail', 'Profile\DetailController@update')->name('profile.detail.update');
	   	// Manage Matches
		Route::get('/profile/matches', 'Profile\MatchesController@index')->name('profile.matches.index');

		// Realtor Profile
//		Route::get('/profile/sales', 'Profile\SalesProfileController@index')->name('profile.sales.index');
//		Route::get('/profile/sales/create', 'Profile\SalesProfileController@create')->name('profile.sales.create');
//		Route::post('/profile/sales', 'Profile\SalesProfileController@store')->name('profile.sales.store');
//		Route::match(['PUT', 'PATCH'], '/profile/sales/{realtor}', 'Profile\SalesProfileController@update')->name('profile.sales.update');
//
//		Route::post('/profile/realtor-sale', 'Profile\RealtorSalesController@store')->name('profile.realtor-sale.store');
//		Route::match(['PUT', 'PATCH'], '/profile/realtor-sale/{realtor_sale}', 'Profile\RealtorSalesController@update')->name('profile.realtor-sale.update');

		// Edit Password
		Route::get('/profile/password', 'Profile\PasswordController@index')->name('profile.password.edit');
		Route::match(['PUT', 'PATCH'], '/profile/password', 'Profile\PasswordController@update')->name('profile.password.update');

		Route::post('/profile/avatar', 'Profile\AvatarController@store')->name('profile.avatar.store');

		// User Routes
		Route::post('/user/{user}/report', 'Users\UsersController@report')->name('user.report');
		Route::post('/user/{user}/block', 'Users\UsersController@block')->name('user.block');
		Route::post('/user/{user}/unblock', 'Users\UsersController@unblock')->name('user.unblock');

		//Review Routes
        Route::get('/review/', 'ReviewsController@index')->name('reviews.your');
        Route::post('/review/', 'ReviewsController@create')->name('reviews.create');
//        Route::get('/review/{user_id}', 'ReviewsController@UserIndex')->name('reviews.others');
        Route::get('/review/{review}/reject', 'ReviewsController@reject')->name('reviews.reject');
        Route::post('/review/{review}/reject', 'ReviewsController@rejectSubmit')->name('reviews.reject');
        Route::get('/review/{review}/accept', 'ReviewsController@accept')->name('reviews.accept');
        Route::get('/review/{review}/delete', 'ReviewsController@delete')->name('reviews.delete');
        Route::get('/review/{review}/override', 'ReviewsController@override')->name('reviews.override');
        Route::post('/review/{review}/override', 'ReviewsController@overrideSubmit')->name('reviews.overrideSubmit');
        Route::get('/review/{review}/edit', 'ReviewsController@edit')->name('reviews.edit');
        Route::match(['PUT', 'PATCH'], '/review/{review}/edit', 'ReviewsController@editSubmit')->name('reviews.editSubmit');

        // Message Center
        Route::post('/user/{user}/unblock', 'Users\UsersController@unblock')->name('user.unblock');

        // User Matching routee
        Route::post('/matches/{user}/request-match', 'Profile\MatchesController@requestMatch')->name('matches.request-match');
        Route::post('/matches/{match}/confirm-match', 'Profile\MatchesController@confirmMatch')->name('matches.confirm-match');
        Route::post('/matches/{match}/remove-match', 'Profile\MatchesController@removeMatch')->name('matches.remove-match');
		Route::post('/matches/{match}/reject-match', 'Profile\MatchesController@rejectMatch')->name('matches.reject-match');
		Route::post('/matches/{user}/request-renew-match', 'Profile\MatchesController@requestRenewMatch')->name('matches.request-renew-match');
		Route::post('/matches/{match}/confirm-renew-match', 'Profile\MatchesController@confirmRenewMatch')->name('matches.confirm-renew-match');
        Route::post('/matches/{match}/reject-renew-match', 'Profile\MatchesController@rejectRenewMatch')->name('matches.reject-renew-match');

		// Message Center
		Route::get('/message-center', 'MessageCenter\MessageCenterController@index')->name('message-center.index');
        Route::get('/message-center/test', 'MessageCenter\MessageCenterController@test')->name('message-center.test');
		
        // Manage Subscriptions Profile
		Route::get('/profile/subscriptions', 'Profile\SubscriptionController@index')->name('profile.subscription.index');
        Route::post('/profile/subscriptions/renew', 'Profile\SubscriptionController@renew')->name('profile.subscription.renew');
        Route::post('/profile/subscriptions/attach-payment-method', 'Profile\SubscriptionController@attachPaymentMethod')->name('profile.subsctiption.attachPaymentMethod');
        Route::post('/profile/subscriptions/cancel', 'Profile\SubscriptionController@cancel')->name('profile.subsctiption.cancel');
		Route::get('/profile/payment-invoice', 'Profile\SubscriptionController@paymentInvoice')->name('profile.subscription.paymentInvoice');
        
        // Payments
        Route::get('/profile/payment', 'Profile\PaymentController@index')->name('profile.payment.index');
        Route::get('/profile/payment/token', 'Profile\PaymentController@token')->name('profile.payment.token');
        Route::get('/profile/payment/plans', 'Profile\PaymentController@plans')->name('profile.payment.plans');
        Route::get('/profile/payment/show/{braintree_plan}', 'Profile\PaymentController@show')->name('profile.payment.show');
		Route::post('/profile/payment/subscribe', 'Profile\PaymentController@subscribe')->name('profile.payment.subscribe');
		Route::get('/profile/payment/download-invoice/{invoiceId}', 'Profile\PaymentController@downloadInvoice')->name('profile.payment.download-invoice');
		Route::post('/profile/payment/cancel-subscription', 'Profile\PaymentController@cancelSubscription')->name('profile.payment.cancel-subscription');
		Route::post('/profile/payment/resume-subscription', 'Profile\PaymentController@resumeSubscription')->name('profile.payment.resume-subscription');
		Route::get('/profile/payment/change-subscription', 'Profile\PaymentController@changeSubscriptionShow')->name('profile.payment.change-subscription-show');
		Route::post('/profile/payment/change-subscription', 'Profile\PaymentController@changeSubscriptionStore')->name('profile.payment.change-subscription-store');
		Route::get('/profile/payment/update-card-show', 'Profile\PaymentController@updateCardShow')->name('profile.payment.update-card-show');
		Route::post('/profile/payment/update-card-store', 'Profile\PaymentController@updateCardStore')->name('profile.payment.update-card-store');
		Route::get('/profile/payment/purchase-matches', 'Profile\PaymentController@purchaseMatchesShow')->name('profile.payment.purchase-matches-show');
		Route::post('/profile/payment/purchase-matches', 'Profile\PaymentController@purchaseMatchesStore')->name('profile.payment.purchase-matches-store');
		
		Route::get('/profile/payment/upgrade-vendor-plan','Profile\PaymentController@loadUpgradeVendorPlan')->name('profile.payment.upgrade-vendor-plan');
		Route::post('/profile/payment/vendor-plan-upgrade','Profile\PaymentController@upgradeVendorPlan')->name('profile.payment.vendor-plan-upgrade');
	
		// Settings
		Route::get('/profile/settings', 'Profile\SettingsController@index')->name('profile.settings.index');
		Route::post('/profile/settings', 'Profile\SettingsController@update')->name('profile.settings.update');
		
		
		Route::get('/upgrade/plan/{id}','Profile\PaymentController@loadUpgradePlan')->name('loadUpgradePlan');
		Route::post('/upgrade/plan/{id}','Profile\PaymentController@upgradePlan')->name('upgradePlan');
		Route::get('/cancel/upgrade/{id}','Profile\PaymentController@loadCancelUpgrade')->name('loadCancelUpgrade');
		Route::post('/cancel/upgrade/{id}','Profile\PaymentController@cancelUpgrade')->name('cancelUpgrade');
	}
);

//Route::group([
//		'namespace' => 'Pub',
//		'middleware' => 'auth',
//		'as' => 'match.suggest.'
//	],
//	function() {
//		Route::get('/suggest/by-user/{user}', 'Matching\SuggestController@byUser')->name('by-user');
//		Route::get('/suggest/by-state/{state}', 'Matching\SuggestController@byState')->name('by-state');
//		Route::get('/suggest/by-exp', 'Matching\SuggestController@byExp')->name('by-exp');
//		Route::get('/suggest/by-sales', 'Matching\SuggestController@bySalesTotal')->name('by-sales-total');
//		Route::get('/suggest/by-value', 'Matching\SuggestController@bySalesValue')->name('by-sales-value');
//	}
//);

//Route::group([
//		'namespace' => 'Pub',
//		'middleware' => 'auth',
//		'as' => 'match.search.'
//	],
//	function() {
//		Route::get('/search/by-user/{user}', 'Matching\SuggestController@byUser')->name('by-user');
//		Route::get('/search/by-state/{state}', 'Matching\SuggestController@byState')->name('by-state');
//	}
//);

/**
 * Admin Routes
 */
Route::group([
        'namespace' => 'Admin',
        'prefix' => 'cpldashrbcs',
        'middleware' => ['auth', 'can:admin']
    ],
    function() {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        Route::get('/realtors', 'RealtorsController@index')->name('admin.realtors');
        Route::get('/realtors/{id}', 'RealtorsController@edit');
        Route::post('/update', 'RealtorsController@update');
        Route::get('/brokers', 'BrokersController@index')->name('admin.brockers');
        Route::get('/brokers/{id}', 'RealtorsController@edit');
        Route::get('/paid-brokers', 'BrokersController@paid');
        Route::get('/paid-brokers/{id}', 'RealtorsController@edit');
        Route::get('/unpaid-brokers/{id}', 'RealtorsController@edit');
        Route::get('/unpaid-brokers', 'BrokersController@unpaid');
        Route::get('/consumers', 'ConsumersController@index');
        Route::get('/consumers/{id}', 'RealtorsController@edit');
        // Route::get('/uploaded-users', 'UploadUsersController@index')->name('uploadedUsers');
        Route::match(array('GET', 'POST'), '/uploaded-users', 'UploadUsersController@index')->name('uploadedUsers');
        Route::post('/import-users', 'UploadUsersController@import')->name('importusers');
        Route::get('/notify-users', 'ConsumersController@notifyUsers');
        Route::get('/logout', 'ConsumersController@logout');

        // Admin Blogs Routes
        Route::match(array('GET', 'POST'), '/blogs', 'BlogsController@index');
        // Route::get('/blogs', 'BlogsController@index');
        Route::get('/blogs/new', 'BlogsController@newBlog');
        Route::post('/blogs/create', 'BlogsController@createBlog');
        Route::post('/blogs/update', 'BlogsController@updateBlog');
        Route::post('/blogs/delete', 'BlogsController@deleteBlog');
        Route::post('/blogs/check-blog', 'BlogsController@checkDuplicateBlog');
        Route::get('/blogs/{id}', 'BlogsController@editContent');
        // Route::get('/blogs/{title}/{id}', 'BlogsController@editContent');

        // Admin Blog Taxonomies Routes
        Route::get('/taxonomies', 'TaxonomyController@index');
        Route::get('/taxonomies/new', 'TaxonomyController@newTaxonomy');
        Route::post('/taxonomies/create', 'TaxonomyController@createTaxonomy');
        Route::post('/taxonomies/update', 'TaxonomyController@updateTaxonomy');
        Route::post('/taxonomies/delete', 'TaxonomyController@deleteTaxonomy');
        Route::post('/taxonomies/check-blog', 'TaxonomyController@checkDuplicateTaxonomy');
        Route::get('/taxonomies/{id}', 'TaxonomyController@editContent');
        

        Route::get('/pages', 'PagesController@index');
        Route::get('/pages/new', 'PagesController@newPage');
        Route::post('/pages/create', 'PagesController@createPage');
        Route::post('/pages/update', 'PagesController@updatePage');
        Route::post('/pages/check-page', 'PagesController@checkDuplicatePage');
        Route::get('/pages/{title}/{id}', 'PagesController@editContent');
        Route::get('/pages/{title}/{id}', 'PagesController@editContent');
        
        // Home and Register Page Builder Routes
        // --> Home
        Route::get('/homepage/edit', 'PageBuilderController@editHomePage')->name('admin.pages.edit-home-page');
        Route::post('/homepage/update', 'PageBuilderController@updateHomePage')->name('admin.pages.update-home-page');
        // --> Realtor Register
        Route::post('/register/update', 'PageBuilderController@updateRegisterPage')->name('admin.pages.update-register-page');
        Route::get('/register/realtor/edit', 'PageBuilderController@editRealtorRegisterPage')->name('admin.pages.edit-realtor-register-page');
        // --> Lender Register
        Route::get('/register/lender/edit', 'PageBuilderController@editLenderRegisterPage')->name('admin.pages.edit-lender-register-page');
        // --> Vendor Register
        Route::get('/register/vendor/edit', 'PageBuilderController@editVendorRegisterPage')->name('admin.pages.edit-vendor-register-page');
        
        // --> Property Leads Listing
        Route::get('/leads/property', 'LeadsController@indexPropertyLeads')->name('admin.leads.property');
        Route::get('/leads/property/view/{lead_id}', 'LeadsController@viewPropertyLead')->name('admin.leads.property.view');
        // Route::post('/get-property-leads-by-filter', 'LeadsController@getPropertyLeadsByFilter')->name('admin.leads.property.filter');
        Route::post('/get-leads-by-filter', 'LeadsController@getLeadsByFilter')->name('admin.leads.filter');

        // --> Property Leads Listing
        Route::get('/leads/refinance', 'LeadsController@indexRefinanceLeads')->name('admin.leads.refinance');
        Route::get('/leads/refinance/view/{lead_id}', 'LeadsController@viewRefinanceLead')->name('admin.leads.refinance.view');
        // Route::post('/get-refinance-leads-by-filter', 'LeadsController@getRefinanceLeadsByFilter')->name('admin.leads.refinance.filter');

        Route::get('/testimonials', 'PagesController@testimonials');
        Route::get('/testimonials/new', 'PagesController@newTestimonial');
        Route::post('/testimonials/create', 'PagesController@createTestimonial');
        Route::post('/testimonials/update', 'PagesController@updateTestimonial');
        Route::get('/testimonial/edit/{id}', 'PagesController@editTestimonial');
        Route::get('/testimonial/{id}', 'PagesController@viewTestimonial');
        Route::post('/pages/delete-testimonial', 'PagesController@deleteTestimonial');
		Route::post('/users/delete-user', 'UsersController@deleteUser');
        Route::resource('/users', 'UsersController', ['as' => 'admin']);
        Route::get('add-designation','UsersController@loadAdddesignation');
        Route::post('add-designation','UsersController@addDesignation');
        Route::get('users-with-designation','UsersController@loadAllUsersWithDesignation');
        Route::get('user/{user_id}/leads','UsersController@viewUserLeads')->name('admin.user.leads');
        Route::get('edit-user/{id}','UsersController@loadUpdateDesignation');
        Route::post('edit-user/{id}','UsersController@updateDesignation');
        Route::post('/autocomplete/fetch', 'UsersController@fetchAutocompleteUser')->name('autocomplete.fetch');
        Route::get('/all-matches','RealtorsController@listRealtorMatches');
        Route::get('/add-matches','DashboardController@adminAddmatches');
        Route::post('/add-matches','DashboardController@add_manual_matches')->name('addManualMatch');
        Route::get('/fetchavailbalelender','DashboardController@fetchAvailableLender')->name('checkconnection.lender');
      
        
        Route::get('/add-vendor','VendorController@laodAddVendorLayout');
        Route::post('/add-vendor','VendorController@registerVendorWithDetails');
        Route::post('/check-vendor-email', 'UsersController@checkEmail');
        Route::post('/check-vendor-phone', 'UsersController@checkPhone');
        Route::get('/packages/{id}','VendorController@loadAllPackages')->name('loadVendPackages');
        Route::get('/package-payment','VendorController@loadPaymentLayout')->name('paymnet-layout');
        Route::post('/package-payment', 'VendorController@makeVendorPackagePayment');
        Route::get('/all-vendors','VendorController@listAllVendor')->name('admin.vendors');
        Route::get('/edit-vendor/{id}','VendorController@loadEditVendor');
        Route::post('edit-vendor/{id}','VendorController@updateVenderDetails');
        Route::get('/add-industry','VendorController@loadAddIndustry');
        Route::post('/industry/file-upload','VendorController@uploadIndustryFile')->name('uploadIndustryImage');
        Route::post('/add-industry','VendorController@addIndustry');
        Route::get('/all-industry','VendorController@allIndustry');
        Route::get('/edit-industry/{id}','VendorController@editIndustry');
        Route::post('/edit-industry/{id}','VendorController@updateIndustry');

        // Setting Routes
        Route::get('/price-settings','SettingsController@pricing')->name("settings.pricing");
        Route::post('/price-settings','SettingsController@storePricing')->name("settings.storepricing");
        Route::get('/price-settings/create-vendor-package','SettingsController@createVendorPackage')->name("settings.vendorPackage.create");
        Route::get('/price-settings/edit-vendor-package/{packageId}','SettingsController@editVendorPackage')->name("settings.vendorPackage.edit");
        Route::post('/price-settings/store-vendor-package','SettingsController@storeVendorPackage')->name("settings.vendorPackage.store");
    }
);
Route::POST('/check-username', 'Admin\UsersController@checkUsername');
Route::POST('/check-license', 'Admin\UsersController@checkLicense');
Route::POST('/check-email', 'Admin\UsersController@checkEmail');
Route::POST('/check-phone', 'Admin\UsersController@checkPhone');
Route::POST('/check-zip', 'Admin\UsersController@checkZip');
Route::POST('/notify-me', 'Admin\UsersController@notifyMe');
Route::post('/billing-information', 'Pub\Users\UsersController@billingInformation');
Route::get('/thankyou/{id}', 'Pub\Users\UsersController@registerThankyou')->name('register.thankyou');
Route::get('/account-status/{id}', 'Pub\Users\UsersController@accountStatus')->name('register.accountstatus');
Route::post('/user-registration', 'Pub\Users\UsersController@createUser');
Route::post('/consumer-register', 'Pub\Users\UsersController@createConsumer');
Route::get('/partially-registration/{id}', 'Pub\Users\UsersController@partiallyRegistration');
Route::get('/platinum-membership-upgrade/{id}', 'Pub\Users\UsersController@platiniuMemberUpgrade');
Route::get('/lender-billing-details/{id}', 'Pub\Users\UsersController@loadLenderBillingDetails')->name("lenderBillingDetails");
Route::post('/lender-billing-details/{id}', 'Pub\Users\UsersController@storeLenderBillingDetails');

Route::post('/create-subscription', 'Pub\Users\UsersController@createCustomerSubscription')->name('register.createCustomerSubscription');
Route::post('/create-payment', 'Pub\Users\UsersController@createStripePayment')->name('register.createStripePayment');
Route::post('/update-customer', 'Pub\Users\UsersController@updateCustomerPaymentMethod')->name('register.updateCustomerPaymentMethod');
Route::get('/payment-status/{user_id}', 'Pub\Users\UsersController@paymentStatus')->name('register.paymentStatus');
Route::get('/subscription-renewed/{user_id}', 'Pub\Users\UsersController@subscriptionRenewed')->name('register.subscriptionRenewed');
Route::post('/stripe-webhook', 'StripeWebhook@manageSubscriptionStatus')->name('stripe.webhook');

Route::get('/cpldashrbcs/login', 'Admin\UsersController@showLogin');
Route::post('/cpldashrbcs/login', 'Admin\UsersController@doLogin');
Route::get('/cpldashrbcs/logout', function(){
    Auth::logout();
    return Redirect::to('/cpldashrbcs/login');
});



Route::post('/get-city', 'Pub\Users\UsersController@getCity');
Route::post('/get-previouscity','Pub\Users\UsersController@getPreviousCity');



Route::get('/azure-server-images','AzureImages@fetchAzureServerProfilePicture');
Route::get('/azure-small-profile-images','AzureImages@fetchsmallAzureProfilePictures');
Route::get('/azure-medium-profile-images','AzureImages@fetchmediumAzureProfilePictures');
Route::get('/azure-large-profile-images','AzureImages@fetchlargeAzureProfilePictures');
Route::get('/azure-xsmall-profile-images','AzureImages@fetchxlargeAzureProfilePictures');
Route::get('/azure-large-into-normal','AzureImages@fetchLargeIntoNormalImage');
Route::get('/azure-without-size-large','AzureImages@fetchLargeWithoutSize');


Route::get('/vendor-register','Auth\RegisterController@loadVendorRegLayout')->name('pick-package');
Route::post('/vendor-register','Auth\RegisterController@registerVendor')->name('register-vendor');

Route::get('/vendor-packages/{id}','Auth\RegisterController@loadAllVendorPackages')->name('loadVendorPackages');
Route::get('/vendor-platinum-membership-packages/{id}','Auth\RegisterController@loadPlatiniumVendor')->name('loadPlatiniumVendor');
Route::get('/vendor-package-payment','Auth\RegisterController@loadPackagePayment')->name('package-payment');
// Route::post('/vendor-package-payment', 'Vendor@packagePayment');
Route::post('/vendor-package-payment', 'Vendor@createCustomerSubscription')->name('vendor.createCustomerSubscription');
Route::post('/update-vendor-payment', 'Vendor@updateCustomerPaymentMethod')->name('vendor.updateCustomerPaymentMethod');
Route::post('/advertisement/banner','VendorAdvertisement@uploadAdvertisementBanner')->name('advertisementBanner');
Route::match(['POST', 'GET'], '/geoUsers', 'HomeController@fetchGeolocationUsers')->name('geolocationUsers');



