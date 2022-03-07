<?php

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

Route::get('/', 'HomeController@index');
Route::post('/remove-website', 'HomeController@removeWeb');
Route::post('/remove-email', 'HomeController@removeEmail');
Route::post('/add-website', 'HomeController@addWeb');
Route::post('/add-email', 'HomeController@addEmail');
Route::post('/update-website', 'HomeController@updateWebsite');
Route::post('/update-email', 'HomeController@updateEmail');
Route::get('/settings', 'HomeController@settings');
Route::post('/save-config', 'HomeController@saveConfig');
Route::get('/emails', 'HomeController@emails');
Route::get('/test', 'HomeController@test');


Route::get('email-test', function(){
  
    $details['email'] = 'tran.thanh.tuan269@gmail.com';
  
    dispatch(new App\Jobs\SendEmailJob($details));
  
    dd('done');
});
