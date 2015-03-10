@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{ $article['title'] }} :: @parent
@stop

{{-- Content --}}
@section('content')
<!-- Content -->
<div class="row">
    <!--Article -->
    <div class="article-main {{ $article['hotlist'] ? 'col-md-8' : 'col-md-12' }}">
        <div class="row article-info">
            <div class="col-sm-10 col-xs-12"> 
                <h3>{{ $article['title'] }}</h3>
                <span class="text-muted">
                    <span class="info-item" title="发布时间"><span class="glyphicon glyphicon-time"></span><time class="timeago" datetime="{{{ $article['date'] }}}">{{{ $article['date'] }}}</time></span>
                    @if (isset($article['view_num']))
                    <span class="info-item" title="浏览次数"><span class="glyphicon glyphicon-eye-open"></span><span id="view_num">{{{ $article['view_num'] }}}</span></span>
                    @endif
                    @if (isset($article['comment_num']))
                    <span class="info-item" title="评论数"><span class="glyphicon glyphicon-comment"></span><span id="comment_num">{{{ $article['comment_num'] }}}</span></span>
                    @endif
                    <span class="info-item" title="来源">
                        <span class="glyphicon glyphicon-import"></span>
                        @if (isset($article['sourceLink']))
                        <a target="_blank" href="{{{ $article['sourceLink'] }}}" >{{{ $article['source'] }}}</a>
                        @else
                        {{{ $article['source'] }}}
                        @endif
                    </span>
                    <span class="info-item" title="原文链接">
                        <a target="_blank" href="http://www.cnbeta.com/articles/{{{ $article['id'] }}}.htm" ><span class="glyphicon glyphicon-link"></span></a>
                    </span>
                </span>
            </div>
            <div class="col-sm-2 thumbnail hidden-xs"><img alt="{{{ $article['topicTitle'] }}}" title="{{{ $article['topicTitle'] }}}" src="{{{ replaceImgURL($article['topicImage']) }}}"></div>

        </div>
        <div class="article-intro well">
            {{ $article['intro'] }}
        </div>
        <p>{{ replaceImgURL($article['content']) }}</p>
        <div>
            <span class="badge">
                {{{ $article['author'] }}}
            </span>
        </div>
    </div>
    <!-- /.article -->

    <!-- Hot Comment -->
    <aside class="hot-comment col-md-4 {{ $article['hotlist'] ? '' : 'hidden' }}">
        <div class="panel panel-default widget">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-comment"></span>
                <h3 class="panel-title">最热评论</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    @if ($article['hotlist'])
                    @for ($i = 0; $i < count($article['hotlist']); $i++)
                    <li class="list-group-item">
                        <div class="list-item-info">
                            <span class="right"><span class="glyphicon glyphicon-map-marker"></span>{{ $article['hotlist'][$i]['from'] }}<span class="glyphicon glyphicon-time"></span>{{ $article['hotlist'][$i]['date'] }}</span>
                            <span class="glyphicon glyphicon-user"></span>{{ $article['hotlist'][$i]['author'] }}
                        </div>
                        <div class="comment-text">{{ nl2br($article['hotlist'][$i]['content']) }}</div>
                        <div class="action">
                            <button type="button" class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-thumbs-up"></span><span class="vote_num">{{ $article['hotlist'][$i]['up'] }}</span></button><button type="button" class="btn btn-danger btn-xs" disabled="disabled"><span class="glyphicon glyphicon-thumbs-down"></span><span class="vote_num">{{ $article['hotlist'][$i]['down'] }}</span></button>
                        </div>
                    </li>
                    @endfor
                    @endif
                </ul>
            </div>
        </div>
    </aside>
    <!-- ./ comment -->

</div>
<!-- ./ content -->
<!-- duoshuo -->
<div class="ds-thread" data-thread-key="{{ $article['id'] }}" data-title="{{ $article['title'] }}" data-url="http://cnbeta1.com/{{{ $article['id'] }}}"></div>
<!-- ./ duoshuo -->
@stop

@section('scripts')

{{ Minify::javascript('/assets/js/cnbeta1_view.js') }}

<script type="text/javascript">
    @if ($needRefresh)
    //ajax sync article detail
    syncArticleDetail({{ $article['id'] }});
    @endif
    //duoshuo
    var duoshuoQuery = {short_name:"cnbeta1"};
	(function() {
		var ds = document.createElement('script');
		ds.type = 'text/javascript';ds.async = true;
		ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
		ds.charset = 'UTF-8';
		(document.getElementsByTagName('head')[0]
		 || document.getElementsByTagName('body')[0]).appendChild(ds);
	})();
</script>

@stop
