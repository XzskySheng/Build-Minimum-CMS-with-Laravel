@extends('layouts.default')

@section('main')
    <div class="am-g am-g-fixed">
        <div class="am-u-sm-12">
            <h1>发布信息</h1>
            <hr/>
            @if ($errors->has())
                <div class="am-alert am-alert-danger" data-am-alert>
                    <p>{{ $errors->first() }}</p>
                </div>
        @endif
        <!-- 发布信息表单 -->
            <form action="/article" method="post" accept-charset="utf-8" class="am-form">
                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                <div class="am-form-group">
                    <label for="title">标题</label>
                    <input id="title" name="title" type="text" value=""/>
                </div>
                <div class="am-form-group">
                    <label for="content">内容</label>
                    <textarea id="content" name="content" rows="20"></textarea>
                    <p class="am-form-help">
                        <button id="preview" type="button" class="am-btn am-btn-xs am-btn-primary">
                            <span class="am-icon-eye"></span> 预览
                        </button>
                    </p>
                </div>
                <div class="am-form-group">
                    <label for="tags">标签</label>
                    <input id="tags" name="tags" type="text" value="{{ Input::old('tags') }}"/>
                    <p class="am-form-help">多个标签之间用逗号隔开 ","</p>
                </div>
                <p>
                    <button type="submit" class="am-btn am-btn-success">
                        <span class="am-icon-send"></span> 发布
                    </button>
                </p>
            </form>
        </div>
    </div>

    <!-- 文章预览窗口 -->
    <div class="am-popup" id="preview-popup">
        <div class="am-popup-inner">
            <div class="am-popup-hd">
                <h4 class="am-popup-title">失物招领</h4>
                <span data-am-modal-close
                      class="am-close">&times;</span>
            </div>
            <div class="am-popup-bd">
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#preview').on('click', function() {
                $('.am-popup-title').text($('#title').val());
                $.post('preview', {'content': $('#content').val(),'_token':$('#token').val()}, function(data, status) {
                    $('.am-popup-bd').html(data);
                });
                $('#preview-popup').modal();
            });
        });
    </script>
@endsection