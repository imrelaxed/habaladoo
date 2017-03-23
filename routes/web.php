<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Static Pages
Route::get('/',              'StaticPageController@index');
Route::get('about',          'StaticPageController@about');
Route::get('pricing',        'StaticPageController@pricing');
Route::get('contact',        'StaticPageController@contact');
Route::get('terms-of-use',   'StaticPageController@termsOfUse');
Route::get('privacy-policy', 'StaticPageController@privacyPolicy');
Route::get('components',     'StaticPageController@components');

/* Helper class that generates the routes required for user authentication

    // Authentication Routes...
        $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
        $this->post('login', 'Auth\LoginController@login');
        $this->post('logout', 'Auth\LoginController@logout')->name('logout');
    // Registration Routes...
        $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        $this->post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...
        $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        $this->post('password/reset', 'Auth\ResetPasswordController@reset');
*/
Auth::routes();

// Admin controls
Route::get('admin', 'AdminController@getIndex');
Route::post('admin/update-settings', 'AdminController@postUpdateSettings');
Route::get('admin/users', 'AdminController@getUsers');
Route::get('admin/developer-zone', 'AdminController@getDeveloperZone');
Route::get('admin/analytics', 'AdminController@getAnalytics');
Route::get('admin/engine-room', 'AdminController@getEngineRoom');
Route::get('admin/clear-logs', 'AdminController@getClearLogs');
Route::get('admin/logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Admin plan controls
Route::get('admin/plans', 'AdminController@getPlans');
Route::get('admin/flush-cached-plans', 'AdminController@getFlushCachedPlan');
Route::get('admin/import-subscription-plans', 'AdminController@getImportSubscriptionPlans');
Route::post('admin/update-cached-plan/{plan_id}', 'AdminController@postUpdateCachedPlan');
Route::post('admin/delete-cached-plan/{plan_id}', 'AdminController@postDeleteCachedPlan');
Route::post('admin/delete-stripe-plan/{plan_id}', 'AdminController@postDeleteStripePlan');


// User controller
Route::group(['prefix' => 'user'], function(){

    Route::get('settings', 'UserController@getSettings')->name('settings');
    Route::post('settings', 'UserController@postUpdateSettings');

    Route::get('password', 'UserController@getChangePassword');
    Route::post('password', 'UserController@postChangePassword');

    Route::get('billing', 'UserController@getBilling')->name('billing')->middleware('subscribed');

    Route::get('invoices', 'InvoiceController@index')->name('invoices');
    Route::get('invoice/{id}', 'InvoiceController@download')->name('downloadInvoice');

});


// Subscription Controller
Route::get('/plan/{id}', 'SubscriptionController@show')->name('plan');
Route::group(['prefix' => 'subscription', 'middleware' => 'auth'], function(){

    Route::post('/', 'SubscriptionController@subscribe')->name('subscribe');
    Route::post('update-credit-card', 'SubscriptionController@postUpdateCreditCard');
    Route::get('cancel', 'SubscriptionController@confirmCancellation')->name('confirmCancellation');
    Route::post('cancel', 'SubscriptionController@cancelSubscription')->name('subscriptionCancel');
    Route::post('resume', 'SubscriptionController@resumeSubscription');
    Route::get('resume', 'SubscriptionController@resumeSubscription')->name('subscriptionResume');
    Route::post('swap-plan', 'SubscriptionController@postSwapPlan')->name('swapPlans');

});


// Other
Route::get('home', 'HomeController@index')->name('home');
Route::get('home/your', 'HomeController@index');

// Email Testing Routes
Route::get('test/email', function(){ return view('emails.layout'); });
Route::get('test/email/password-reset', function(){ return view('emails.password'); });
Route::get('test/email/new-sign-up', function(){
    return view('emails.welcome')->with('app_settings', App\ApplicationSetting::find(1));
});
//Route::get('t', 'UserController@testNotify');

// Handling Stripe Webhooks
Route::post('stripe/webhook', 'WebhookController@handleWebhook');

