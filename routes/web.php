<?php

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
    $v = Redis::incr('visits');
    return view('welcome')->withV($v);
});

Route::get('/chat', function () {
    return view('chat');
})->middleware('auth');

Route::get('/messages', function () {
    return App\Message::with('user')->get();
})->middleware('auth');

Route::post('/messages', function () {
    return App\Message::create(['user_id'=> Auth::id(), 'message'=>request()->message]);
})->middleware('auth');
// tinker -> factory(App\User::class)->make();
// tinker -> App\User::first()->messages()->create(["message"=>"hello, ashu!"]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
