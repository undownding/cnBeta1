@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
出错了 :: @parent
@stop

{{-- Content --}}
@section('content')
<h3>出错了：{{ $error }}</h3>
<p>有问题请联系renznn@gmail.com</p>
@stop