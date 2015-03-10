@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
捐助 :: 
@parent
@stop

{{-- Content --}}
@section('content')

<h3>通过捐款支持本站</h3>
<p>
如果你喜欢cnBeta1的话，可以通过捐款的方式，支持作者继续开发和维护本项目以及在服务器上的支出等。<br />
联系方式: renznn@gmail.com
<hr>

<h4>Paypal: </h4>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="renznn@gmail.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="cnbeta1.com">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypalobjects.com/zh_XC/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal——最安全便捷的在线支付方式！">
<img alt="" border="0" src="https://www.paypalobjects.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
</form>

<hr>

<h4>支付宝捐款 (renznn@gmail.com): </h4><br />
<img class="donate-barcode" alt="My Alipay Barcode" src="{{{ asset('assets/img/alipay_me.png') }}}">
</p>

@stop
