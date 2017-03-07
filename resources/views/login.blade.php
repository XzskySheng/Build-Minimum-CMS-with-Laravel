<!-- 模板继承 -->
@extends('layouts.default')
@section('main')
    <div class="am-g am-g-fixed">
        <div class="am-u-lg-6 am-u-md-8">
            <br/>

            <!-- 交互信息提示 -->
            @if (Session::has('message'))
                <div class="am-alert am-alert-{{ Session::get('message')['type'] }}" data-am-alert>
                    <p>{{ Session::get('message')['content'] }}</p>
                </div>
            @endif
            @if ($errors->has())
                <div class="am-alert am-alert-danger" data-am-alert>
                    <p>{{ $errors->first() }}</p>
                </div>
        @endif

        <!-- 登陆表单 -->
            <form action="login" method="post" accept-charset="utf-8" class="am-form">
                <!-- 添加 token 值 -->
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label  for="email">E-mail:
                    <input type="email" name="email" value="{{Input::old('email')}}" placeholder="请输入email..">
                </label>
                <br>
                <label for="password">密码:
                    <input type="password" name="password" value="" placeholder="请输入密码..">
                </label>
                <br>
                <label for="remember_me">
                    <input id="remember_me" name="remember_me" type="checkbox" value="1">
                    记住我
                </label>
                <br>
                <div class="am-cf">
                    <input type="submit" name="submit" value="登录" class="am-btn am-btn-primary am-btn-sm am-fl">
                </div>
            </form>

            <br/>
        </div>
    </div>
@endsection