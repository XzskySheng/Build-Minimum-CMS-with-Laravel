@extends('layouts.default')

@section('main')
    <div class="am-g am-g-fixed">
        <div class="am-u-lg-6 am-u-md-8">
            <br/>
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

        <!-- 个人信息界面 -->
            <form action="{{URL::to('user/'.$user->id)}}" method="post" accept-charset="utf-8" class="am-form">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="email">Email：
                    <br>
                    <input type="email" name="email" value="" placeholder="请输入email.." class="">
                </label>
                <br>
                <label for="nickname">用户名:
                    <br>
                    <input type="text" name="nickname" value="" placeholder="请输入用户名..">
                </label>
                <br>
                <label for="old_password">旧密码:
                    <br>
                    <input type="password" name="old_password" value="" placeholder="请输入以前的密码..">
                </label>
                <br>
                <label for="password">新密码:
                    <br>
                    <input type="password" name="password" value="" placeholder="请输入新密码..">
                </label>
                <br>
                <label for="confirm_password">确认密码:
                    <br>
                    <input type="password" name="password_confirmation" value="" placeholder="确认密码..">
                </label>
                <br>
                <div class="am-cf">
                    <input type="submit" name="submit" value="修改" class="am-btn am-btn-primary am-btn-sm am-fl">
                </div>
            </form>

            <br/>
        </div>
    </div>
@endsection