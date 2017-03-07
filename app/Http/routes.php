<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function()        //主页内容
{
    $articles = App\Article::with('user', 'tags')->orderBy('created_at', 'desc')->paginate(6);    //分页
    $tags = App\Tag::where('count', '>', '0')->orderBy('count', 'desc')->orderBy('updated_at', 'desc')->take(10)->get();
    return view('index')->with('articles', $articles)->with('tags', $tags);
});
//登陆路由
Route::get('login', function()
{
    return view('login');
});
//post登陆数据
Route::post('login', function()
{
    //数据验证规则
    $rules = array(
        'email'       => 'required|email',
        'password'    => 'required|min:6',
        'remember_me' => 'boolean',
    );
    $validator = Validator::make(Request::all(), $rules);
    //验证通过
    if ($validator->passes())
    {
        if (Auth::attempt([
            'email'    => Request::input('email'),
            'password' => Request::input('password'),
            'block'    => 0],
            (boolean) Request::input('remember_me')))
        {
            return Redirect::to('home');
        }
        //账号或密码错误
        else {
            return Redirect::to('login')->withInput()->with('message', ['type' => 'danger', 'content' => '账号或密码错误']);
        }
    }
    //数据格式错误
    else {
        return Redirect::to('login')->withInput()->withErrors($validator);
    }
});
//访问主页
Route::get('home', ['middleware' => 'auth', function()
{
    return view('home')->with('user', Auth::user())->with('articles', App\Article::with('tags')->where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get());
}]);
//退出到主页
Route::get('logout', ['middleware' => 'auth', function()
{
    Auth::logout();
    return Redirect::to('/');
}]);
//注册路由
Route::get('register', function()
{
    return view('users.create');
});
//注册操作路由
Route::post('register', function()
{
    $rules = [
        'email' => 'required|email|unique:users,email',
        'nickname' => 'required|min:4|unique:users,nickname',
        'password' => 'required|min:6|confirmed',
    ];
    $validator = Validator::make(Request::all(), $rules);
    if ($validator->passes())
    {
        $user = new App\User();
        $user->email = Request::input('email');
        $user->nickname = Request::input('nickname');
        $user->password = Hash::make(Request::input('password'));
        if ($user->save())
        {
            return Redirect::to('login')->with('message', array('type' => 'success', 'content' => '注册成功，请登录'));
        } else {
            return Redirect::to('register')->withInput()->with('message', array('type' => 'danger', 'content' => '注册失败'));
        }
    } else {
        return Redirect::to('register')->withInput()->withErrors($validator);
    }
});
//编辑个人信息路由
Route::get('user/{id}/edit', ['middleware' => 'auth', 'as' => 'user.edit', function($id)
{
    //如果是管理员或者是登陆用户则显示个人信息
    if (Auth::user()->is_admin or Auth::id() == $id) {
        return view('users.edit')->with('user', App\User::find($id));
    } else {
        //否则跳转至主页
        return Redirect::to('/');
    }
}]);
//用户修改的信息
Route::post('user/{id}', ['middleware' => 'auth', function($id)
{
    if (Auth::user()->is_admin or (Auth::id() == $id)) {
        $user = App\User::find($id);
        //验证数据格式
        $rules = array(
            'password' => 'required_with:old_password|min:6|confirmed',
            'old_password' => 'min:6',
        );
        if (!(Input::get('nickname') == $user->nickname))
        {
            $rules['nickname'] = 'required|min:4||unique:users,nickname';
        }
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes())
        {
            if (!(Input::get('old_password') == '')) {
                if (!Hash::check(Input::get('old_password'), $user->password)) {
                    return Redirect::route('user.edit', $id)->with('user', $user)->with('message', array('type' => 'danger', 'content' => '旧密码错误'));
                } else {
                    $user->password = Hash::make(Input::get('password'));
                }
            }
            $user->nickname = Input::get('nickname');
            $user->save();
            //修改成功返回信息
            return Redirect::route('user.edit', $id)->with('user', $user)->with('message', array('type' => 'success', 'content' => '修改成功'));
        } else {
            //返回错误信息
            return Redirect::route('user.edit', $id)->withInput()->with('user', $user)->withErrors($validator);
        }
    } else {
        return Redirect::to('/');
    }
}]);
//路由群组：前缀为 admin ，已登录且为管理员
Route::group(['prefix' => 'admin', 'middleware' => ['auth','isAdmin']], function()
{
    //用户列表管理
    Route::get('users', function()
    {
        return view('admin.users.list')->with('users', App\User::all())->with('page', 'users');
    });
});

//路由群组：已登录且为管理员
Route::group(['middleware' => ['auth','isAdmin']], function()
{
    //密码重置
    Route::get('user/{user}/reset', function(App\User $user)
    {
        $user->password = Hash::make('123456');
        $user->save();
        return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => '重置密码成功'));
    });
    //锁定用户
    Route::get('user/{user}/delete', function(App\User $user)
    {
        $user->block = 1;
        $user->save();
        return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => '锁定用户成功'));
    });
//解锁用户
    Route::get('user/{user}/unblock', function(App\User $user)
    {
        $user->block = 0;
        $user->save();
        return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => '解锁用户成功'));
    });
});
Route::post('article/preview', ['middleware' => 'auth', 'uses' => 'ArticleController@preview']);
Route::resource('article', 'ArticleController');
Route::get('user/{user}/articles', 'UserController@articles');

