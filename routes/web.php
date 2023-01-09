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
    // $combinations = collect([1,2,3])->crossJoin([4,5,6],[7,8])->map(function($combination){
    //     return collect($combination)->implode('-');
    // });
    // dd($combinations);
    // foreach($choosedAttributes as $categoryId => $categoryAttributes)
    // {
    //     foreach($categoryAttributes as $attribute)
    //     {
    //         dd($categoryId,$categoryAttributes,$attribute);
    //     }
    // }
    return view('welcome');
});

Route::resource('/products','ProductController');
Route::get('/get-combinations', "ProductController@getCombinations");
