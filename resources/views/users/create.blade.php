@extends('layouts.default')

@section('main')
    <div class="am-g am-g-fixed">
        <div class="am-u-lg-6 am-u-md-8">
            <br/>
            <!-- 信息提示 -->
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
        <!-- 注册表单 -->
            <form action="register" method="post" accept-charset="utf-8" class="am-form">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <!-- {{ csrf_field() }} -->
                <label for="email">E-mail:
                    <br>
                    <input type="email" name="email" value="请输入email..">
                </label>
                <br>
                <label for="nickname">用户名:
                    <br>
                    <input type="text" name="nickname" value="请输入用户名..">
                </label>
                <br>
                <label for="password">密码:
                    <br>
                    <input type="password" name="password" value="">
                </label>
                <br>
                <label for="confirm_password">确认密码:
                    <br>
                    <input type="password" name="password_confirmation" value="">
                </label>
                <br>
                <div class="am-cf">
                    <input type="submit" name="submit" value="注册" class="am-btn am-btn-primary am-btn-sm am-fl">
                </div>
            </form>
            <br/>
        </div>
    </div>
@endsection