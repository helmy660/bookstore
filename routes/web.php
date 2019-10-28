<?php


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
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

Route::resource('users', 'UserController');
Route::resource('comments','CommentController') ; 

Route::get('users/{user}',  ['as' => 'users.edit', 'uses' => 'UserController@edit']);
Route::patch('home/{user}/updateProfile',  ['as' => 'users.updateProfile', 'uses' => 'UserController@updateProfile']);
// Route::patch('home/{user}/changePassword',  ['as' => 'users.changePassword', 'uses' => 'UserController@changePassword']);
Route::patch('home/changePassword',  ['as' => 'users.changePassword', 'uses' => 'UserController@changePassword']);


Route::get('booksByCat/{cat_id}/{order_by}','BookController@getCategoryBooks');
Route::get('/user/{order_by}','BookController@getallBooks');

Route::get('leased/{order_by}','BookController@getAllLeasedBooks');
Route::get('leased/bycat/{cat_id}/{order_by}','BookController@getLeasedBooksByCat');

Route::get('favourite/{order_by}','BookController@getAllFavouriteBooks');
Route::get('favourite/bycat/{cat_id}/{order_by}','BookController@getFavouriteBooksByCat');


Route::post('addToFav', 'UserBookController@addToFav');
Route::post('leaseBook', 'UserBookController@leaseBook');
Route::resource('books', 'BookController');
Route::get('/admin', 'UserController@admin_home');
Route::resource('categories', 'CategoryController');
Route::post('rateBook', 'UserBookController@rateBook');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/home/{user}/changePassword','UserController@showChangePasswordForm');
// Route::post('/home/{user}/changePassword','UserController@changePassword')->name('changePassword');
Route::get('/home/changePassword','UserController@showChangePasswordForm');
Route::post('/home/changePassword','UserController@changePassword')->name('changePassword');
Route::post('/login/custom', ['uses' => 'Auth\LoginController@login' , 'as' => 'login.custom']);
