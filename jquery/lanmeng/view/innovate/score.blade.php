@extends('layouts.main')

@section('banner')
@endsection

@section('header-scripts')
@endsection

@section('content')
<div class="score">
<div class="container">
    <div>
        <img src="/img/jft.jpg" width="1130" height="1795" usemap="#Map">
        <map name="Map">
            <area shape="poly" coords="306,695" href="#">
            <area shape="poly" coords="463,908" href="#">
            <area shape="poly" coords="313,694,865,598,889,669,332,798" href="/store" target="_blank">
            <area shape="poly" coords="342,830,880,723,893,789,357,890" href="/mine" target="_blank">
            <area shape="poly" coords="361,929,893,831,913,888,378,1017" href="/bbs" target="_blank">
            <area shape="poly" coords="381,1055,823,973,846,1044,395,1123" href="/innovate/example" target="_blank">
            <area shape="poly" coords="401,1157,858,1071,883,1133,413,1216" href="/innovate/invest-list" target="_blank">
            <area shape="poly" coords="423,1256,933,1151,962,1216,439,1343" href="/store" target="_blank">
          </map>
    </div>
</div>
</div>
@endsection


