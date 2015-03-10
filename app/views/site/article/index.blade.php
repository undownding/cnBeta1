@extends('site.layouts.default')

{{-- Content --}}
@section('content')

<!-- Fetch New Button -->
<button style="display: none;" type="button" id="got-new-article-button" onclick="showNewArticles()" class="btn btn-info btn-lg btn-block"></button>
<!-- ./ fetch new button -->

<!-- Article List -->
<div id="article-list">
    @foreach ($articleList as $article)
    <div class="row" data-id="{{ $article['article_id'] }}">
        <div class="col-sm-10">
            <div class="article-item">
                <h4><strong><a target="_blank" href="/{{ $article['article_id'] }}">{{ $article['title'] }}</a></strong></h4>
                <span class="text-muted">
                    <span class="info-item" title="发布时间"><span class="glyphicon glyphicon-time"></span><time class="timeago" datetime="{{{ $article['date'] }}}">{{{ $article['date'] }}}</time></span>
                    <span class="info-item" title="浏览次数"><span class="glyphicon glyphicon-eye-open"></span><span id="view_num">{{{ $article['view_num'] }}}</span></span>
                    <span class="info-item" title="评论数"><span class="glyphicon glyphicon-comment"></span><span id="comment_num">{{{ $article['comment_num'] }}}</span></span>
                    <span class="info-item" title="来源">
                        <span class="glyphicon glyphicon-import"></span>
                        @if (isset($article['source_link']) && !empty($article['source_link']))
                            <a target="_blank" href="{{{ $article['source_link'] }}}" >{{{ $article['source'] }}}</a>
                        @else
                            {{{ $article['source'] }}}
                        @endif
                    </span>
                </span>
            </div>
            <p>
                {{ $article['intro'] }}
            </p>
        </div>
        <div class="col-sm-2 hidden-xs">
            <a target="_blank" href="/{{{ $article['article_id'] }}}" class="thumbnail"><img src="{{{ replaceImgURL($article['topic']) }}}" alt=""></a>
        </div>
    </div>

    <hr />
    @endforeach
</div>
<!-- ./ article list -->

<!-- More Article Icon -->
<div style="display: none;" id="more-article-loading-icon"><i class="fa fa-circle-o-notch fa-spin fa-lg"></i></div>
<!-- ./ more article icon -->
@stop

@section('scripts')

{{ Minify::javascript('/assets/js/cnbeta1_index.js') }}

@stop
