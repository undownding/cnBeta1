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
        <meta name="theme-color" content="#000000">

        <!-- CSS
        ================================================== -->
        <link rel="stylesheet" href="http://cdn.staticfile.org/twitter-bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://cdn.staticfile.org/font-awesome/4.1.0/css/font-awesome.min.css">
        
        {{ Minify::stylesheet('/assets/css/cnbeta1.css') }}

        <!-- Favicons
        ================================================== -->
        <link rel="shortcut icon" href="{{{ asset('favicon.ico') }}}" type="image/x-icon" />
        <link rel="icon" sizes="192x192" href="{{{ asset('assets/ico/icon-highres.png') }}}">
        <link rel="apple-touch-icon" href="{{{ asset('assets/ico/apple-touch-icon.png') }}}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{{ asset('assets/ico/apple-touch-icon-57x57.png') }}}" />
        <link rel="apple-touch-icon" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72x72.png') }}}" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{{ asset('assets/ico/apple-touch-icon-76x76.png') }}}" />
        <link rel="apple-touch-icon" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114x114.png') }}}" />
        <link rel="apple-touch-icon" sizes="120x120" href="{{{ asset('assets/ico/apple-touch-icon-120x120.png') }}}" />
        <link rel="apple-touch-icon" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144x144.png') }}}" />
        <link rel="apple-touch-icon" sizes="152x152" href="{{{ asset('assets/ico/apple-touch-icon-152x152.png') }}}" />
        
        <!-- Scripts
        ================================================== -->
        <script src="http://cdn.staticfile.org/jquery/1.11.1/jquery.min.js"></script>
        {{ Minify::javascript('/assets/js/jquery.timeago.js') }}

        <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "//hm.baidu.com/hm.js?a510672f7e63d9c2053e81ce62d5c210";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
        </script>
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
                            <li {{ (Request::is('robot') ? ' class="active"' : '') }}> <a href="{{{ URL::to('robot') }}}"><i class="fa fa-twitter fa-lg"></i> Twitter 机器人</a></li>
                            <li {{ (Request::is('usage') ? ' class="active"' : '') }}> <a href="{{{ URL::to('usage') }}}"><span class="glyphicon glyphicon-book"></span> 说明</a></li>
                            <li {{ (Request::is('donate') ? ' class="active"' : '') }}><a href="{{{ URL::to('donate') }}}"><span class="glyphicon glyphicon-heart"></span> 捐助</a></li>
                            <li class="hidden-xs"><a target="_blank" href="{{{ URL::to('feed') }}}"><i class="fa fa-rss fa-lg"></i></a></li>
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
                    <li>By <a target="_blank" href="http://ohrz.net">Renzhn</a></li>
                </ul>
            </div>
        </div>
        
        <script src="http://cdn.staticfile.org/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
        
        {{ Minify::javascript('/assets/js/jquery.bootstrap-autohidingnavbar.min.js') }}
        
        @yield('scripts')
        
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-49884496-5', 'auto');
          ga('send', 'pageview');
        </script>

    </body>
</html>
