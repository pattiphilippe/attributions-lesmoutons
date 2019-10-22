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
    return view('auth.login');
})->middleware('guest')->name('accueil');

Route::resource('professeurs', 'ProfesseurController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/commits', 'CommitController@index')->name('commits');
Route::resource('groupes','GroupController');
Route::get('/courses', 'CourseController@index');
