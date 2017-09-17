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



//请求与相应
Route::group(['prefix' => 'test'], function () {
    Route::get('request', function (\Illuminate\Http\Request $request) {
        return json_encode($request);
    });
});
//获取请求路径
Route::get('path','TestController@test');

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
 Route::get('response',function (){
//      return response('返回内容',201,['name'=>'tom']);
//     return response()->json(['name'=>'tom'],201,[]);
       $aaa = new stdClass();
       $aaa ->name ='tom';
//        return response()->json(['name'=>'tom','user'=>$aaa],201);
     return response()->redirectTo('http://www.baidu.com');
   });
});

//数据库
Route::group(['prefix' => 'db-test'],function (){
    Route::group(['prefix' => 'nativity'],function (){
        Route::post('select',function (){
            $table =DB::select('show tables');
            //DB是一个facade（门面），用于便捷的访问数据库操作对象-类似于指定入口
            //log 日志记录，使用相关函数可以查看框架操作日志
            //重点：select可以执行查询语句（也可以执行其他操作），返回结果对象，且以集合的方式返回
            Log::debug('tables',[$table]);
            return $table;
        });
        Route::post('insert',function (){
            //重点：insert可以执行插入语句，返回操作是否成功
            $created_at =date('Y-m-d H:i:s');
            $email = time().'@qq.com';
            $charu = DB::insert("insert into `users` (`name`,`email`,`password`,`created_at`)
                                            value ('zhai','$email','123456','$created_at')" );
            return $charu?'插入成功':'插入失败';
        });
        Route::post('update',function (){
            //重点：update返回操作受影响行数（被修改了数据的行数，一个数字）
            $xiugai1 = DB::update("update `users` set `password` = ?",['87654321']);
            $xiugai2 = DB::update("update `users` set `name` = :name",['name' => 'new-name']);
            return[
                'xiugai1'=>$xiugai1,
                'xiugai2'=>$xiugai2
            ];
        });
        Route::post('delete', function () {
            // delete 操作返回被删除的行数（数字）
            $xiugai = DB::delete("delete from `users` where name = :name", ['name' => 'new-name']);
            return $xiugai;
        });
        Route::post('statement', function () {
            // 用于执行没有返回值的语句
            DB::statement("drop table `password_resets`");
        });
        // 事务操作
        Route::post('auto-transaction', function () {
            // 自动事务
            // 当sql语句操作成功时，自动提交
            // 失败时，自动回滚（无任何返回值）
            DB::transaction(function () {
                DB::update("update `users` set `name` = :name", ['name' => 'new-name']);
                throw new Exception('手动抛出一个异常');
                DB::update("update `users` set `name` = :name", ['name' => 'name']);
            });
        });
        Route::post('transaction', function () {
            // 手动操作事务
            // 包含 beginTransaction, commit rollBack
            //可自定义添加返回数据以达到检测事务流程运行状态的目的
            DB::beginTransaction();
            try {
                DB::update("update `users` set `name` = :name", ['name' => 'new-name']);
//                throw new Exception('手动抛出一个异常');
                DB::commit();
                return '事务提交了，数据被提交到数据库中了';
            } catch (Exception $exception) {
                DB::rollBack();
                return '事务回滚了，数据操作被取消';
            }
        });
        Route::post('bind', function () {
            // 参数绑定
            // 命名绑定
            $xiugai11 = DB::update("update `users` set `name` = :name, `password` = :password", ['name' => 'new-name', 'password' => '111111']);
            // 位置绑定
            $xiugai22 = DB::update("update `users` set `name` = ?, `password` = ?", ['old-name', '222222']);
            return [
                '1' => $xiugai11,
                '2' => $xiugai22
            ];
        });
    });
    Route::group(['prefix' =>'structure'],function (){
        Route::post('get',function (){
            //获取所有符合条件的值
            return DB::table('users')->get();
        });
        Route::post('first',function (){
            //获取符合条件的第一条数据，返回一个对象
            $aaa =DB::table('users')->first();
            return response()->json($aaa);
        });
        Route::post('value',function (){
            //只返回单个值
            return DB::table('users')->value('name');
        });
        Route::post('pluck',function (){
            //查询并返回符合条件的一列数据
            return DB::table('users')->pluck('email');
        });
        Route::post('polymeric',function (){
            //count (统计符合条件数据条数)
            //max(统计符合条件数据里最大值)
            //min
            //sum
          //  return DB::table('users')->count();
            //return DB::table('users')->max('id');
            //return DB::table('users')->min('id');
            return DB::table('users')->sum('id');
        });

    });
});