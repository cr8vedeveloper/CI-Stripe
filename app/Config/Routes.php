<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->add('/', 'Index::index');

$routes->add('/terms-of-use', function() {
	echo view('rules/termsofuse.php');
});
$routes->add('/privacy-policy', function() {
	echo view('rules/privacypolicy.php');
});
$routes->add('/specifiedTransaction', function() {
	echo view('rules/specifiedTransaction.php');
});

$routes->group('auth', function($routes) {
	$routes->add('login', 'Auth::login');
	$routes->add('logout', 'Auth::logout');
	$routes->add('regist', 'Auth::regist');
	$routes->add('active-account', 'Auth::activeAccount');
	$routes->add('forgot-password', 'Auth::forgetPassword');
	$routes->add('reset-password', 'Auth::resetPassword');
});

$routes->add('home', 'Home::home');
$routes->add('analysis', 'Home::analysis');
$routes->add('history', 'Home::history');
$routes->add('account', 'Home::account');
$routes->add('config', 'Home::config');
$routes->group('user', function($routes) {
	$routes->add('/', 'UserController::index');
	$routes->group('api', function($routes) {
		$routes->add('updateAccount', 'UserController::updateAccount');
		$routes->add('updatePassword', 'UserController::updatePassword');
		$routes->add('uploadCSV', 'UserController::uploadCSV');
		$routes->add('insertMethod', 'UserController::insertMethod');
		$routes->add('updateMethod', 'UserController::updateMethod');
		$routes->add('deleteMethod', 'UserController::deleteMethod');
		$routes->add('saveConfig', 'UserController::saveConfig');
		$routes->add('getTotalBalance', 'UserController::getTotalBalance');
	});
});

$routes->group('payment', function($routes) {
	$routes->add('pricing-table', 'StripeController::index');
	$routes->add('stripe-pay', 'StripeController::stripePay');
	$routes->add('stripe-success', 'StripeController::stripeSuccess');
	$routes->add('stripe-subscription', 'StripeController::stripeSubscription');
	$routes->add('stripe-subscription-cancel', 'StripeController::stripeSubscriptionCancel');
	$routes->add('stripe-webhook', 'StripeController::stripeWebhook');
});

$routes->group('api', function($routes)
{
	$routes->add('insertTrade', 'Api::insertTrade');
	$routes->add('updateTrade', 'Api::updateTrade');
	$routes->add('deleteTrade', 'Api::deleteTrade');

	$routes->add('loadNote', 'Api::loadNote');
	$routes->add('saveNote', 'Api::saveNote');

	$routes->add('insertAccount', 'Api::insertAccount');
	$routes->add('updateAccount', 'Api::updateAccount');
	$routes->add('deleteAccount', 'Api::deleteAccount');

	// $routes->add('insertMethod', 'Api::insertMethod');
	// $routes->add('updateMethod', 'Api::updateMethod');
	// $routes->add('deleteMethod', 'Api::deleteMethod');

	// $routes->add('saveConfig', 'Api::saveConfig');

	// $routes->add('getTotalBalance', 'Api::getTotalBalance');

	$routes->add('getWinningAverage', 'Api::getWinningAverage');
	$routes->add('getTodayResult', 'Api::getTodayResult');
	$routes->add('getChartData', 'Api::getChartData');
	// $routes->add('uploadCSV', 'Api::uploadCSV');

	// $routes->add('confirm/(:any)/(:any)', 'Login::confirm/$1/$2');
	// $routes->add('regist/(:any)/(:any)', 'Login::regist/$1/$2');
	/**
	 * Stripe Function
	 */
	$routes->add('payStripe', 'StripeController::stripePost');
});

$routes->group('admin', function($routes)
{
	$routes->add('/', 'Admin::home');
	$routes->group('api', function($routes) {
		$routes->add('deleteUser', 'Admin::deleteUser');
		$routes->add('updateUser', 'Admin::updateUser');
	});
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
