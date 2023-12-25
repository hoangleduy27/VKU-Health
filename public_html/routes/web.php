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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/clear-cache', function() {
    // system('chmod -R gu+w storage');
    // system('chmod -R guo+w storage');
    // system('php artisan cache:clear');
    // \Artisan::call('dump-autoload');
    // exec('composer require intervention/image');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});