<?php

use App\Page;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $page = Page::first();
    return view('home', compact('page'));
});
Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/checkout', 'CheckoutController@index');
Route::get('/pay/{product}', 'CheckoutController@create');
Route::prefix('admin')->group(function(){
    Route::get('/media/indexApi', 'MediaController@indexApi');
    Route::resources([
        'products' => 'ProductController',
        'features'  => 'FeatureController',
        'schedules' => 'ScheduleController',
        'licenses'  => 'LicenseController',
        'times'      => 'TimeController',
        'pages'     => 'PageController',
        'reviews'   => 'ReviewController',
        'customers'  => 'CustomerController',
        'media'   => 'MediaController'
    ]);
    
});
Route::resources([
    'products' => 'ProductController',
    'features'  => 'FeatureController',
    'schedules' => 'ScheduleController',
    'licenses'  => 'LicenseController',
    'times'      => 'TimeController',
    'pages'     => 'PageController',
    'reviews'   => 'ReviewController',
    'customers'  => 'CustomerController'
]);
Route::get('/customer/search', 'CustomerController@searchApi');
Route::get('/paystack/redirect');
Route::get('/payments/refund/create', 'PaymentController@refund_create');
Route::post('/payments/refund', 'PaymentController@refund');