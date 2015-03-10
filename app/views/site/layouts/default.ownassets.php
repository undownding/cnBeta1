<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8" />
        <title>
            @section('title')
            cnBeta1
            @show
        </title>
        <meta name="keywords" content="cnBeta1, cnBeta" />
        <meta name="author" content="Renzhn" />
        <meta name="description" content="一个干净、现代、开放的cnBeta" />

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- CSS
        ================================================== -->
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
        
        {{ Minify::stylesheet('/assets/css/cnbeta1.css') }}

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Favicons
        ================================================== -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
        <link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
        <link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
    </head>

    <body>
        <!-- To make sticky footer need to wrap in a div -->
        <div id="wrap">
            <!-- Navbar -->
            <div class="navbar navbar-default navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <span class="logo"><a href="{{{ URL::to('') }}}"><img alt="cnBeta1 Logo" src="{{{ asset('assets/img/cnbeta1.png') }}}"></a></span>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav hidden-xs">
                            <li class="logo-title{{ (Request::is('/') ? ' active' : '') }}"><a href="{{{ URL::to('') }}}">首页</a></li>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li {{ (Request::is('usage') ? ' class="active"' : '') }}> <a href="{{{ URL::to('usage') }}}"><span class="glyphicon glyphicon-book"></span> 使用说明</a></li>
                            <li {{ (Request::is('donate') ? ' class="active"' : '') }}><a href="{{{ URL::to('donate') }}}"><span class="glyphicon glyphicon-heart"></span> 捐助</a></li>
                            <li><a target="_blank" href="{{{ URL::to('feed') }}}"><i class="fa fa-rss fa-lg"></i></a></li>
                        </ul>
                        <!-- ./ nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- ./ navbar -->

            <!-- Container -->
            <div class="container main">
                <!-- Notifications -->
                @include('notifications')
                <!-- ./ notifications -->

                <!-- Content -->
                @yield('content')
                <!-- ./ content -->
            </div>
            <!-- ./ container -->

            <!-- the following div is needed to make a sticky footer -->
            <div id="push"></div>
        </div>
        <!-- ./wrap -->

        <hr>

        <div class="footer">
            <div class="container">
                <p>cnBeta1.com 一个干净、现代、开放的cnBeta</p>
                <ul class="footer-links">
                    <li><a href="{{{ URL::to('about') }}}">关于</a></li>
                    <li>·</li>
                    <li><a href="{{{ URL::to('api') }}}">API</a></li>
                    <li>·</li>
                    <li>By <a target="_blank" href="http://weibo.com/ohrz">Renzhn</a></li>
                </ul>
            </div>
        </div>

        {{ Minify::javascript(array('/assets/js/jquery.min.js', '/assets/js/bootstrap.min.js', '/assets/js/jquery.timeago.js')) }}
        
        @yield('scripts')
        
        <div style="text-align: center;"><script type="text/javascript" src="http://js.users.51.la/17252342.js"></script></div>

    </body>
</html>
