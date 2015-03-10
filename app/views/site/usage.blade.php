@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
说明 ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="alert alert-info" role="alert">
    <strong>小提示：</strong>把cnBeta的新闻网址中的cnbeta.com改成cnbeta1.com就可以访问本站相应的新闻
</div>

<h3>特色</h3>
<ul>
    <li>本站全站采用响应式主题，自动适配手机和平板显示</li>
    <li>网站首页可以自动获取最新新闻，无须手动刷新网页；当滑到最底部时自动加载下一页</li>
    <li>新闻页右侧是cnBeta的热门评论，下面是本站的评论（不会关评论的哦亲）</li>
</ul>

<hr>
<h3>RSS 订阅</h3>
<p>
    本站提供<strong>全文RSS</strong>, 地址: <a target="_blank" href="http://cnbeta1.com/feed">http://cnbeta1.com/feed</a>
</p>

<hr>
<h3>一些细节</h3>
<ul>
    <li>如果你会改hosts而且太热爱本站了，可以把cnbeta.com指向本站的IP，反正文章内容一样可以显示</li>
    <li>cnBeta的热门评论中，评论中的换行不会显示，算是一个bug，在这可以正常显示（我是通过API发现的）</li>
    <li>本站后台会持续从cnBeta抓取数据，包括文章列表和文章详情；文章详情缓存时间为15分钟，缓存失效后当文章被访问会使后台重新抓取文章详情（主要是热门评论）</li>
</ul>

<hr>
<h3>更新日志</h3>
<ul>
    <li>2015-01-17: 热门文章及评论推送机器人：Twitter <a target="_blank" href="https://twitter.com/cnbeta1">@cnbeta1</a> & 新浪微博 <a target="_blank" href="http://weibo.com/cnbeta1bot">@cnBetaOne</a></li>
    <li>2015-01-16: 首页上显示新闻的浏览量、评论量和来源</li>
    <li>2014-11-05: 适应cnbeta的修改</li>
    <li>2014-08-23: 新闻日期以相对时间来显示</li>
</ul>
@stop
