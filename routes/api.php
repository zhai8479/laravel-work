<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test', function () {
    return 'test闭包写法';
});

Route::get('test1','TestController.php@test');

Route::post('test', function () {
    return 'post写法';
});
Route::put('test', function () {
    return 'put写法';
});
Route::patch('test', function () {
    return 'patch写法';
});
Route::delete('test', function () {
    return 'delete写法';
});
Route::options('test', function () {
    return 'options写法';
});
//多种方法都可以的
Route::match(['test','post'] ,'match',function () {
    return 'match兼容写法';
});
//任意请求方法
Route::any('any', function () {
    return 'any任意写法';
});

//路由参数

//必选参数
Route::get('luyou/{id}', function ($id) {
    return "id is $id";
});
//多个必选参数
Route::get('lu/{id}/name/{name}', function ($id,$name) {
    return "$id 路由的名字是 $name";
});
//可选路由参数
Route::get('school/{name?}', function ($name = '汉口学院')  {
    return "school name is $name";
});

//正则表达式约束
Route::get('class/{id}/name/{name}', function ($id,$name) {
    return "id is $id, name is $name";
})->where(['id'=>'[0-9]+','name'=>'[A-Za-z]+']);

//全局约束
Route::get('sex/{sex}', function ($sex) {
    return "id is $sex";
});

//命名路由
Route::get('genmulu', function () {
    $url = route('genmulu');
    return "genmulu is $url";
})->name('genmulu');

//跳转到设定
Route::get('go/genmulu', function () {
    return redirect()->route('genmulu');
});