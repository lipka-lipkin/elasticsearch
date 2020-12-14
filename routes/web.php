<?php

use App\Models\Article;
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

Route::any('/articles', function (){

//    phpinfo();
//    xdebug_info();

    $i = ['qwe', 'asd', 'zxc'];
    foreach ($i as $a){
        echo $a;
    }
    dd(123);


    return view('articles', ['articles' => Article::all()->toArray()]);
});



