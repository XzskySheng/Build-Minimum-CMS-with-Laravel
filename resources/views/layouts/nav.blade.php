<!-- navbar -->
<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only"
        data-am-collapse="{target: '#collapse-head'}"><span class="am-sr-only">nav switch</span>
    <span class="am-icon-bars"></span></button>
<div class="am-collapse am-topbar-collapse" id="collapse-head">
    <!-- 如果登陆，显示退出按钮 -->
    @if (Auth::check())
        @if (Auth::user()->is_admin)
            <ul class="am-nav am-nav-pills am-topbar-nav">
                <li class="{{ (isset($page) and ($page == 'users')) ? 'am-active' : '' }}"><a href="{{ URL::to('admin/users') }}">用户</a></li>
            </ul>
        @endif
        <div class="am-topbar-right">
            <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
                <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-users"></span> {{{ Auth::user()->nickname }}} <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="{{ URL::to('article/create') }}"><span class="am-icon-edit"></span> 发布信息</a></li>
                    <li><a href="{{ URL::to('user/'. Auth::id() . '/edit') }}"><span class="am-icon-user"></span> 个人资料</a></li>
                    <li><a href="{{ URL::to('logout') }}"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </div>
        </div>
            <div class="am-topbar-right">
                <a href="{{ URL::to('user/'. Auth::id() . '/articles') }}" class="am-btn am-btn-primary am-topbar-btn am-btn-sm topbar-link-btn"><span class="am-icon-list"></span> 我的发布</a>
            </div>
        <!-- 否则，显示登陆和注册按钮 -->
    @else
        <div class="am-topbar-right">
            <a href="{{ URL::to('register') }}" class="am-btn am-btn-secondary am-topbar-btn am-btn-sm topbar-link-btn"><span class="am-icon-pencil"></span> 注册</a>
        </div>
        <div class="am-topbar-right">
            <a href="{{ URL::to('login') }}" class="am-btn am-btn-primary am-topbar-btn am-btn-sm topbar-link-btn"><span class="am-icon-user"></span> 登录</a>
        </div>
    @endif
</div>