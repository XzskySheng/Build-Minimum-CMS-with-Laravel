@extends('layouts.default')

@section('main')
    <div class="am-g am-g-fixed">
        <div class="am-u-sm-12">
            <br/>
            @if (Session::has('message'))
                <div class="am-alert am-alert-{{ Session::get('message')['type'] }}" data-am-alert>
                    <p>{{ Session::get('message')['content'] }}</p>
                </div>
        @endif
        <!-- 用户列表显示 -->
            <table class="am-table am-table-hover am-table-striped ">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>E-mail</th>
                    <th>用户名</th>
                    <th>管理</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{{ $user->nickname }}}</td>
                        <td>
                            <a href="{{ URL::to('user/'.$user->id .'/edit') }}" class="am-btn am-btn-xs am-btn-primary">编辑</a>
                            <form action="{{URL::to('user/'.$user->id .'/reset')}}" method="get" accept-charset="utf-8" style="display: inline;">
                                <button type="button" class="am-btn am-btn-xs am-btn-warning" id="reset{{ $user->id }}">重置</button>
                            </form>
                            @if ($user->block)
                                <form action="{{URL::to('user/'.$user->id .'/unblock')}}" method="get" accept-charset="utf-8" style="display: inline;">
                                    <button type="button" class="am-btn am-btn-xs am-btn-danger" id="unblock{{ $user->id }}">解锁</button>
                                </form>
                            @else
                                <form action="{{URL::to('user/'.$user->id .'/delete')}}" method="get" accept-charset="utf-8" style="display: inline;">
                                    <button type="button" class="am-btn am-btn-xs am-btn-danger" id="delete{{ $user->id }}">锁定</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 弹出框 -->
    <div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
        <div class="am-modal-dialog">
            <div class="am-modal-bd">
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>否</span>
                <span class="am-modal-btn" data-am-modal-confirm>是</span>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('[id^=reset]').on('click', function() {
                $('.am-modal-bd').text('你确定要重置密码吗?');
                $('#my-confirm').modal({
                    relatedTarget: this,
                    onConfirm: function(options) {
                        $(this.relatedTarget).parent().submit();
                    },
                    onCancel: function() {
                    }
                });
            });

            $('[id^=delete]').on('click', function() {
                $('.am-modal-bd').text('你确定要锁定吗该用户吗？');
                $('#my-confirm').modal({
                    relatedTarget: this,
                    onConfirm: function(options) {
                        $(this.relatedTarget).parent().submit();
                    },
                    onCancel: function() {
                    }
                });
            });

            $('[id^=unblock]').on('click', function() {
                $('.am-modal-bd').text('你确定要解锁吗？');
                $('#my-confirm').modal({
                    relatedTarget: this,
                    onConfirm: function(options) {
                        $(this.relatedTarget).parent().submit();
                    },
                    onCancel: function() {
                    }
                });
            });
        });
    </script>
@endsection