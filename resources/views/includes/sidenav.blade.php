<?php

?>



<div class="overlay"></div>

<!-- Sidebar -->
<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
    <ul class="nav sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{route('welcome')}}">
                <img src="{{asset('images/logo.jpg')}}"  class="img-rounded" style=" width:30%;" alt="">
            </a>
        </li>
        {{--{{Auth::user()->hasPermission(Auth::id(),"dispatch.create")}}--}}
        <li>
            <a href="{{route('home')}}">Home</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Crates <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu" style="background-color: #292929">
                <li class="dropdown-header">Customers</li>
                @if(hasPermission("dispatch.create"))
                    <li><a href="{{route('dispatch.create')}}">Crates Sent</a></li>
                @endif
                @if(hasPermission("returns.create"))
                <li><a href="{{route('returns.create')}}">Crates Received </a></li>
                @endif
                @if(hasPermission("dispatch.index"))
                <li><a href="{{route('dispatch.index')}}">All Sent Crates</a></li>
                @endif
                @if(hasPermission("returns.index"))
                <li><a href="{{route('returns.index')}}">All Received Crates</a></li>
                @endif
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Freezers <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu" style="background-color:#292929">
                <li class="dropdown-header">Freezer - Menu</li>
                @if(hasPermission("freezer.create"))
                    <li><a href="{{route('freezer.create')}}">Transfer Freezer</a></li>
                @endif
                @if(hasPermission("freezer.return"))
                    <li><a href="{{route('freezer.return')}}">Return Freezer</a></li>
                @endif
                @if(hasPermission("freezer.index"))
                    <li><a href="{{route('freezer.index')}}">All Freezers</a></li>
                @endif
                {{--                    <li><a href="{{route('returns.index')}}">All Return</a></li>--}}
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transfers <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu" style="background-color: #292929">
                <li class="dropdown-header">WAREHOUSE</li>
                @if(hasPermission("transfer.create"))
                <li><a href="{{route('transfer.create')}}">Create Transfer</a></li>
                @endif
                @if(hasPermission("transit"))
                    <li><a href="{{route('transit')}}">Transfer in Transit</a></li>
                @endif
            @if(hasPermission("transfer.index"))
                    <li><a href="{{route('transfer.index')}}">Transfer Received </a></li>
                @endif
                <li><a href="{{route('shipByUser',Auth::user()->id)}}">Transfer Shipped</a></li>

            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Purchase<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu" style="background-color: #292929">
                <li class="dropdown-header">Purchase Menu</li>
                @if(hasPermission("purchase.create"))
                    <li><a href="{{route('purchase.create')}}">Purchase Order</a></li>
                @endif
                @if(hasPermission("purchase.index"))
                    <li><a href="{{route('purchase.index')}}">All Purchases</a></li>
                @endif
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu" style="background-color: #292929">
                <li class="dropdown-header">Reports - Menu</li>
                @if(hasPermission("pdfview"))
                <li><a href="{{route('reportsindex')}}">Download Report</a></li>
                @endif
                @if(hasPermission("stockreport"))
                    <li><a href="{{route('stockreport')}}">View Report</a></li>
                @endif
                {{--@if(hasPermission("freezer.return"))--}}
                {{--<li><a href="{{route('freezer.return')}}">Return Freezer</a></li>--}}
                {{--@endif--}}
                {{--@if(hasPermission("freezer.index"))--}}
                {{--<li><a href="{{route('freezer.index')}}">Show All</a></li>--}}
                {{--@endif--}}
                {{--                    <li><a href="{{route('returns.index')}}">All Return</a></li>--}}
            </ul>
        </li>
        {{--<li class="dropdown">--}}
            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>--}}
            {{--<ul class="dropdown-menu" role="menu">--}}
                {{--<li class="dropdown-header">Dropdown heading</li>--}}
                {{--<li><a href="#">Action</a></li>--}}
                {{--<li><a href="#">Another action</a></li>--}}
                {{--<li><a href="#">Something else here</a></li>--}}
                {{--<li><a href="#">Separated link</a></li>--}}
                {{--<li><a href="#">One more separated link</a></li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
<li>

</li>
    </ul>
</nav>
<!-- /#sidebar-wrapper -->
@if(hasPermission("admin.index"))
    <div class="pull-right" style="position: absolute;
    top:20px;
    right: 0;


    z-index: 1;"><a href="{{route('admin.index')}}" class="btn btn-small " style="background-color: #bd2355;color:white;">Admin Dashboard</a></div>
@endif
<!-- Page Content -->
<div id="page-content-wrapper">

    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
        <span class="hamb-top"></span>
        <span class="hamb-middle"></span>
        <span class="hamb-bottom"></span>
    </button>

</div>