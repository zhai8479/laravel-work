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

Route::get('test1','TestController@test');

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

//命名空间
Route::group(['namespace'=>'\App\Http\Contorllers\Date'], function () {
    Route::get('date','DateController@date' );
    Route::get('show','DateController@show');
});

//路由前缀
Route::group(['prefix'=>'user'],function (){
   Route::post('login',function (){
       return'login';
   });
   Route::get('register',function (){
       return'register';
   });
    Route::group(['prefix'=>'child'],function (){
        Route::post('login',function (){
            return'child login';
        });
        Route::get('register',function (){
            return'child register';
        });
    });
});

//todo 数据库连接有点问题

//请求与相应
Route::group(['prefix' => 'test'], function () {
    Route::get('request', function (\Illuminate\Http\Request $request) {
        return json_encode($request);
    });
});

Route::group(['prefix'=>'test2'],function (){
    //request常用方法
   Route::get('path',function (Request $request){
       return $request->path();
   });
    Route::get('url',function (Request $request){
        return $request->url();
    });
    Route::get('fullurl',function (Request $request){
        return $request->fullurl();
    });
    Route::get('method',function (Request $request){
        return $request->method();
    });
    Route::any('isMethod',function (Request $request){
        return $request->isMethod('GET')?'is get':'not is get';
    });
    //request获取请求数据
    Route::any('all',function (Request $request){
        return $request->all();
    });
    Route::any('input',function (Request $request){
        return $request->input('name','默认值');
    });
    Route::any('only',function (Request $request){
        return $request->only(['name','age']);//取出指定值
    });
    //request获取请求数据
    Route::any('except',function (Request $request){
        return $request->except('name');//不取出指定值
    });
    Route::any('has',function (Request $request){
        return $request->has('name')?'has name':'not has name';
    });

    //request上传文件
    Route::post('hasFile',function (Request $request){
        $hasFile =$request->hasFile('file');
        return $hasFile?'has file':'not has file';
    });
    Route::post('file',function (Request $request){
        $file = $request->file('file');
        return $file->getFilename().'.'.$file->extension();
    });
    Route::post('store',function (Request $request){
        $file = $request->file('file');
         $path = $file->store('avatar');
         return $path;
    });

    //响应
//    todo Route::get('response',function (){
//       return response('返回内容',201,['name'=>'tom']);
//        $aaa new stdClass();
//        $aaa->name ='tom';
//        return response()->json(['name'=>'tom','user'=>$aaa],201);
//    });
});