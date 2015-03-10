@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
API :: 
@parent
@stop

{{-- Content --}}
@section('content')

<h3>API</h3>
<hr>
<ul class="list-group">
    <li class="list-group-item">
        <h4 class="list-group-item-heading">获取首页新闻</h4>
        <p class="list-group-item-text"><code>http://cnbeta1.com/api/getArticles</code></p>
    </li>
    <li class="list-group-item">
        <h4 class="list-group-item-heading">获取更多新闻</h4>
        <p class="list-group-item-text">
            <code>http://cnbeta1.com/api/getMoreArticles/{fromArticleID}</code>
            <var>{fromArticleID}</var>是上次获取的最后一条新闻的ID
        </p>
    </li>
    <li class="list-group-item">
        <h4 class="list-group-item-heading">获取新闻详情</h4>
        <p class="list-group-item-text">
            <code>http://cnbeta1.com/api/getArticleDetail/{ArticleID}</code>
            <var>{ArticleID}</var>是新闻的ID
        </p>
    </li>
</ul>

@stop
