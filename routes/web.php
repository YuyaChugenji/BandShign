<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;

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

// top画面を表示
Route::get('/', function () {
    return view('index');
});

Route::get('/index', function () {
    return view('index');
});

Route::POST('/index', 'BandusersController@login')
->name('index');

Route::get('/bandindexsignupform', 'BandusersController@exebanduser')
->name('index');

// 新規バンドユーザー登録
Route::get('/bandsignupform', 'BandusersController@bandsignup')
->name('bandsignup');

Route::POST('/bandsignupform', 'BandusersController@exebanduser')
->name('bandcreate');

// 新規ライブハウスユーザー登録
Route::get('/livehousesignupform', 'LivehouseusersController@livehousesignup')
->name('livehousesignup');

Route::POST('/livehousesignupform', 'LivehouseusersController@exelivehouseuser')
->name('livehousecreate');

// バンドメインページ
Route::get('/bandindex', 'BandusersController@bandindex')
->name('bandindex');

Route::POST('/bandindex', 'BandhusersController@bandindex')
->name('bandindex');

// ライブハウスメインページ
Route::get('/livehouseindex', 'LivehouseusersController@livehouseindex')
->name('livehouseindex');

Route::POST('/livehouseindex', 'LivehouseusersController@livehouseindex')
->name('livehouseindexs');

// 管理者ライブハウス一覧ページ
Route::get('/adminlivehouseindex', 'AdminusersController@adminlivehouseindex')
->name('adminlivehouseindex');

Route::POST('/adminlivehouseindex', 'AdminusersController@adminlivehouseindex')
->name('adminlivehouseindex');

// 管理者バンド一覧ページ
Route::get('/adminbandindex', 'AdminusersController@adminbandindex')
->name('adminbandindex');

Route::POST('/adminbandindex', 'AdminusersController@adminbandindex')
->name('adminbandindex');

// 管理者バンド詳細ページ
Route::get('/adminbandshow/{id}', 'AdminusersController@adminbandshow')
->name('adminbandshow');

// 管理者バンド削除ページ
Route::POST('//adminbandshow/{id}', 'AdminusersController@exedeleteband')
->name('adminbandshow');

// 管理者バンド削除ページ
Route::POST('//adminbandshow/{id}', 'AdminusersController@exedeleteband')
->name('adminbandshow');

// 管理者ライブ詳細ページ
Route::get('/adminlivehouseshow/{id}', 'AdminusersController@adminlivehouseshow')
->name('adminlivehouseshow');

// 管理者ライブハウス削除ページ
Route::POST('//adminlivehouseshow/{id}', 'AdminusersController@exedeletelivehouse')
->name('adminlivehouseshow');

// バンドマイページ
Route::get('/bandmypage/{id}', 'BandusersController@bandmypage')
->name('bandmypage');

// ライブハウスマイページ
Route::get('/livehousemypage/{id}', 'LivehouseusersController@livehousemypage')
->name('livehousemypage');

// バンド編集ページ
Route::get('/bandedit/{id}', 'BandusersController@bandedit')
->name('bandedit');

Route::POST('/bandedit/{id}', 'BandusersController@exebandedit')
->name('bandedit');

// ライブハウス編集ページ
Route::get('/livehouseedit/{id}', 'LivehouseusersController@livehouseedit')
->name('livehouseedit');

Route::POST('/livehouseedit/{id}', 'LivehouseusersController@exelivehouseedit')
->name('livehouseedit');

// バンドお気に入りページ
Route::get('/bandlikes', function () {
    return view('bandlikes');
});

// ライブハウスお気に入りページ
Route::get('/livehouselikes', function () {
    return view('livehouselikes');
});

// バンド詳細ページ
Route::get('/bandshow/{id}', 'LivehouseusersController@bandshow')
->name('bandshow');
// お気にり登録・解除
Route::POST('/bandshow/{id}', 'LivehouseusersController@exelike')
->name('bandshow');

// ライブハウス詳細ページ
Route::get('/livehouseshow/{id}', 'bandusersController@livehouseshow')
->name('livehouseshow');
// お気にり登録・解除
Route::POST('/livehouseshow/{id}', 'bandusersController@exelike')
->name('livehouseshow');

// バンドお問合せページ
// ページを表示
Route::get('/bandcontact/{id}', 'LivehouseusersController@bandcontact')
->name('bandcontact');
// お問合せを送信
Route::POST('/bandcontact/{id}', 'LivehouseusersController@exebandcontact')
->name('bandcontact');

// ライブハウスお問合せページ
// ページを表示
Route::get('/livehousecontact/{id}', 'bandusersController@livehousecontact')
->name('livehousecontact');
// お問合せを送信
Route::POST('/livehousecontact/{id}', 'bandusersController@exelivehousecontact')
->name('livehousecontact');

// ログアウト
Route::get('/logout', 'bandusersController@logout')
->name('logout');

// パスワード再発行
Route::get('/forgetpassword', 'bandusersController@forgetpassword')
->name('forgetpassword');

Route::POST('/forgetpassword', 'bandusersController@exeforgetpassword')
->name('forgetpassword');

// バンドからお気に入り完了・解除
Route::get('/livehouselike', 'bandusersController@like')
->name('livehouselike');

// バンドからお気に入り一覧
Route::get('/livehouselikeshow/{id}', 'bandusersController@likeshow')
->name('livehouselikeshow');

// ライブハウスからお気に入り完了・解除
Route::get('/bandlike', 'LivehouseusersController@like')
->name('bandlike');

// バンドからお気に入り一覧
Route::get('/bandlikeshow/{id}', 'LivehouseusersController@likeshow')
->name('bandlikeshow');


