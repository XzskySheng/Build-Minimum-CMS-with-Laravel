@extends('layouts.default')
<!-- 展示文章详情 -->
  @section('main')
<article class="am-article">
  <div class="am-g am-g-fixed">
      <div class="am-u-sm-12">
        <br/>
        <div class="am-article-hd">
          <h1 class="am-article-title">{{{ $article->title }}}</h1>
          <p class="am-article-meta">用户: <a href="{{ URL::to('user/' . $article->user->id . '/articles') }}" style="cursor: pointer;">{{{ $article->user->nickname }}}</a> 日期: {{ $article->updated_at }}</p>
        </div>
        <div class="am-article-bd">
            <blockquote>
              标签:
              @foreach ($article->tags as $tag)
                  <a class="am-badge am-badge-success am-radius">{{ $tag->name }}</a>
              @endforeach
            </blockquote>            
          <p>
          {!! $article->resolved_content !!}
        </p>
        </div>
        <br/>
      </div>
  </div>
</article>
@endsection