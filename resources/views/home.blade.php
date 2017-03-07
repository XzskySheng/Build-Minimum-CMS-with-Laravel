@extends('layouts.default')

@section('main')
    <div class="am-g am-g-fixed blog-g-fixed">
        <div class="am-u-sm-12">
            <table class="am-table am-table-hover am-table-striped ">
                <thead>
                <tr>
                    <th>标题</th>
                    <th>标签</th>
                    @if ($user->id == Auth::id())
                        <th>管理</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                <!-- 循环显示发布内容 -->
                @foreach ($articles as $article)
                    <tr>
                        <td><a href="{{ URL::route('article.show', $article->id) }}">{{{ $article->title }}}</a></td>
                        <td>
                            @foreach ($article->tags as $tag)
                                <span class="am-badge am-badge-success am-radius">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <!-- 如果是本用户登陆则显示操作按钮 -->
                        @if ($user->id == Auth::id())
                            <td>
                                <a href="{{ URL::to('article/'. $article->id . '/edit') }}" class="am-btn am-btn-xs am-btn-primary"><span class="am-icon-pencil"></span> 编辑</a>
                                <form action="{{URL::to('article/'.$article->id.'/delete')}}" method="get" accept-charset="utf-8" style="display: inline;">
                                    <button type="button" class="am-btn am-btn-xs am-btn-danger" id="delete{{ $article->id }}">
                                        <span class="am-icon-remove"></span> 删除
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- 确认对话框 -->
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
            $('[id^=delete]').on('click', function() {
                $('.am-modal-bd').text('你确定要删除吗?');
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