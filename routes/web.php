<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

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

Route::get('/todos', 'TodoController@index');           //inside todos directiory file named index.blade.php
Route::get('/todos/create', 'TodoController@create');    //inside todos directiory file named create.blade.php
Route::post('/todos/create','TodoController@store');
Route::get('/todos/edit', 'TodoController@edit');    //inside todos directiory file named edit.blade.php



//the below code is made with a closure
Route::get('/', function () {
    // return  config('services.ses.key'); //this is how we get data from config/services.php -> ses.key
    // return env('APP_NAME');
    // return View::make('welcome');     //using Aaliyas
    return view('welcome');          //using helper function
});
//web.php file shuould be responsible to defining only routes. This makes easy to change  
//the below code is made witsh a controller
Route::get('/user', 'UserController@index'); //UserController --> controller name
                                             //index --> function in that controller
//below code is using closure
// Route::post('/upload', function(){
//     // dd('sdf');  
//     dd(request()->all()); //the requested form will be shown
// });
//but above code is not secure instead use below code for injection
// Route::post('/upload', function(Request $request){
//     // dd($request->all()); //the requested form will be shown --  same as above Route
//     // dd($request->file('image'));    //it will shows null in page Why? enctype="multipart/form-data" should be used in form
//     // dd($request->image); //how can it take the file from the from. Because of enctype="multipart/form-data" in form
//     // dd($request->hasFile('image')); //check if form contains any file or not. (true/false)

//     //store image
//     // $request->image->store('images');    //dir: app/images
//     $request->image->store('images','public'); //'public' key -> filesystem.php | dir: app/public/images
//     return 'uploaded!!!';
// }); 
//to upload image we will use UserController instead
Route::post('/upload', 'UserController@uploadAvatar');
                                     
Auth::routes(); //all the routes for login , password reset, register etc
Route::get('/home', 'HomeController@index')->name('home');

