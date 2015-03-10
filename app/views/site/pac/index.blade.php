@extends('site.layouts.default')

{{-- Content --}}
@section('content')

<div class="page-header">
  <h1>在线白名单PAC配置文件</h1>
</div>

<h4>请求URL格式: <code>/pac/{TYPE}_{HOST}_{PORT}.pac</code></h4>

<br />

<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading">TYPE</h4>
    <p class="list-group-item-text">
        <code>PROXY</code> 使用 HTTP 代理，默认<br />
        <code>SOCKS</code> 使用 SOCKS 代理 <br />
        <code>SOCKS5</code> 使用 SOCKS5 代理 <br />
    </p>
  </div>
  <div class="list-group-item">
    <h4 class="list-group-item-heading">HOST</h4>
    <p class="list-group-item-text">
        <span>代理地址，如<code>127.0.0.1</code> <code>192.168.1.2</code> <code>proxy.example.com</code></span>
    </p>
  </div>
  <div class="list-group-item">
    <h4 class="list-group-item-heading">PORT</h4>
    <p class="list-group-item-text">
        <span>端口号</span>
    </p>
  </div>
</div>

<h4>Example: </h4>
<ul>
    <li>本机1080端口运行着SOCKS5代理服务器：{{ URL::to('/pac/SOCKS5_127.0.0.1_1080.pac') }}</li>
    <li>局域网ip地址为192.168.1.2的机器上在1080端口运行着SOCKS5代理服务器（需要监听局域网网络接口）：{{ URL::to('/pac/SOCKS5_192.168.1.2_1080.pac') }}</li>
    <li>HTTP代理服务器：{{ URL::to('/pac/proxy.example.com_3128.pac') }}</li>
</ul>

<br />

<p class="text-muted">
PAC template from <a href="https://www.pandafan.org/pac/index.html">https://www.pandafan.org/pac/index.html</a>
</p>

@stop
