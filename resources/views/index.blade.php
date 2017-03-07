@extends('layouts.default')

@section('main')
    <div class="am-g am-g-fixed">
        <div class="am-u-md-8">
            <!-- 循环输出文章 -->
            @foreach ($articles as $article)
                <article class="blog-main">
                    <h3 class="am-article-title blog-title">
                        <a href="{{ URL::route('article.show', $article->id) }}">{{{ $article->title }}}</a>
                    </h3>
                    <h4 class="am-article-meta blog-meta">
                        由 <a href="{{ URL::to('user/' . $article->user->id . '/articles') }}">{{{ $article->user->nickname }}}</a> 发布于 {{ $article->created_at->format('Y/m/d H:i') }}
                        <!-- 输出标签 -->
                        @foreach ($article->tags as $tag)
                            <a href="#" style="color: #fff;" class="am-badge am-badge-success am-radius">{{ $tag->name }}</a>
                        @endforeach
                    </h4>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            @if ($article->summary)
                                <p>{!! $article->summary !!}</p>
                            @endif
                            <hr class="am-article-divider"/>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- 显示标签信息侧栏 -->
        <div class="am-u-md-4 blog-sidebar">
            <br/>
            <div class="am-panel-group">
                <section class="am-panel am-panel-default">
                    <div class="am-panel-hd"><span class="am-icon-tags"></span> 标签</div>
                    <ul class="am-list">
                        @for ($i = 0, $len = count($tags); $i < $len; $i++)
                            <li>
                                <a href="#">{{ $tags[$i]->name }}
                                    @if ($i == 0)
                                        <span class="am-fr am-badge am-badge-danger am-round">{{ $tags[$i]->count }}</span>
                                    @elseif ($i == 1)
                                        <span class="am-fr am-badge am-badge-warning am-round">{{ $tags[$i]->count }}</span>
                                    @elseif ($i == 2)
                                        <span class="am-fr am-badge am-badge-success am-round">{{ $tags[$i]->count }}</span>
                                    @else
                                        <span class="am-fr am-badge am-round">{{ $tags[$i]->count }}</span>
                                    @endif
                                </a>
                            </li>
                        @endfor
                    </ul>
                </section>
            </div>
        </div>
    </div>
    {!! $articles->render() !!}
@endsection