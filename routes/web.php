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
})->middleware('guest')->name('index');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('professeurs', 'ProfesseurController');
    Route::resource('groupes', 'GroupController');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/commits', 'CommitController@index')->name('commits');
    Route::get('/courses', 'CourseController@index');

    Route::post('/uploadFileProfessor', 'ProfesseurController@uploadFileProfessor')->name('upload_professor');
    Route::post('/uploadFileGroup', 'GroupController@uploadFileGroup')->name('upload_group');
    Route::post('/uploadFileCourse', 'CourseController@uploadFileCourse')->name('upload_course');

});
