@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
    Twitter 机器人 ::
    @parent
@stop

{{-- Content --}}
@section('content')

    <h3>Twitter 机器人</h3>

    <hr>

    <p>
        <strong>自动推送热门文章及评论！</strong>
    </p>
    <blockquote>
        Twitter ID: <a target="_blank" href="https://twitter.com/cnbeta1">@cnbeta1</a><br />
        <a href="https://twitter.com/cnbeta1" class="twitter-follow-button" data-show-count="false" data-lang="zh-cn"
           data-size="large">关注 @cnbeta1</a>
        <script>!function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + '://platform.twitter.com/widgets.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, 'script', 'twitter-wjs');</script>
    </blockquote>

    <br />

    <h3>新浪微博机器人 <small>Beta</small></h3>

    <hr>

    <p>
        新浪微博ID: <a target="_blank" href="http://weibo.com/cnbeta1bot">@cnBetaOne</a> <br />
        <br />
        <small>由于未通过新浪微博审核，发微博使用的接口不能保证稳定性。</small>
    </p>


@stop
