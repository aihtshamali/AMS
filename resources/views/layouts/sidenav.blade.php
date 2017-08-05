<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> AMS BigBird</title>
    <link rel="icon" href="{{asset('images/logo.jpg')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('js/bootstrap-select-master/css/bootstrap-select.css') }}" rel="stylesheet">--}}

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css">


    <style>


        body {
            position: relative;
            overflow-x: hidden;
        }

        body,
        html {
            height: 100%;
        }

        .nav .open > a,
        .nav .open > a:hover,
        .nav .open > a:focus {
            background-color: transparent;
        }

        /*-------------------------------*/
        /*           Wrappers            */
        /*-------------------------------*/

        #wrapper {
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #wrapper.toggled {
            padding-left: 220px;
        }

        #sidebar-wrapper {
            z-index: 1000;
            left: 220px;
            width: 0;
            height: 100%;
            margin-left: -220px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #1a1a1a;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #sidebar-wrapper::-webkit-scrollbar {
            display: none;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 220px;
        }

        #page-content-wrapper {
            width: 100%;
            padding-top: 70px;
        }

        #wrapper.toggled #page-content-wrapper {
            position: absolute;
            margin-right: -220px;
        }

        /*-------------------------------*/
        /*     Sidebar nav styles        */
        /*-------------------------------*/

        .sidebar-nav {
            position: absolute;
            top: 0;
            width: 220px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .sidebar-nav li {
            position: relative;
            line-height: 20px;
            display: inline-block;
            width: 100%;
        }

        .sidebar-nav li:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            height: 100%;
            width: 3px;
            background-color: #1c1c1c;
            -webkit-transition: width .2s ease-in;
            -moz-transition: width .2s ease-in;
            -ms-transition: width .2s ease-in;
            transition: width .2s ease-in;

        }

        .sidebar-nav li:first-child a {
            color: #fff;
            background-color: #1a1a1a;
        }

        .sidebar-nav li:nth-child(2):before {
            background-color: #ec1b5a;
        }

        .sidebar-nav li:nth-child(3):before {
            background-color: #79aefe;
        }

        .sidebar-nav li:nth-child(4):before {
            background-color: #314190;
        }

        .sidebar-nav li:nth-child(5):before {
            background-color: #279636;
        }

        .sidebar-nav li:nth-child(6):before {
            background-color: #7d5d81;
        }

        .sidebar-nav li:nth-child(7):before {
            background-color: #ead24c;
        }

        .sidebar-nav li:nth-child(8):before {
            background-color: #2d2366;
        }

        .sidebar-nav li:nth-child(9):before {
            background-color: #35acdf;
        }

        .sidebar-nav li:hover:before,
        .sidebar-nav li.open:hover:before {
            width: 100%;
            -webkit-transition: width .2s ease-in;
            -moz-transition: width .2s ease-in;
            -ms-transition: width .2s ease-in;
            transition: width .2s ease-in;

        }

        .sidebar-nav li a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 10px 15px 10px 30px;
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a:active,
        .sidebar-nav li a:focus,
        .sidebar-nav li.open a:hover,
        .sidebar-nav li.open a:active,
        .sidebar-nav li.open a:focus {
            color: #fff;
            text-decoration: none;
            background-color: transparent;
        }

        .sidebar-nav > .sidebar-brand {
            height: 65px;
            font-size: 20px;
            line-height: 44px;
        }

        .sidebar-nav .dropdown-menu {
            position: relative;
            width: 100%;
            padding: 0;
            margin: 0;
            border-radius: 0;
            border: none;
            background-color: #222;
            box-shadow: none;
        }

        /*-------------------------------*/
        /*       Hamburger-Cross         */
        /*-------------------------------*/

        .hamburger {
            position: fixed;
            top: 20px;
            z-index: 999;
            display: block;
            width: 32px;
            height: 32px;
            margin-left: 15px;
            background: transparent;
            border: none;
        }

        .hamburger:hover,
        .hamburger:focus,
        .hamburger:active {
            outline: none;
        }

        .hamburger.is-closed:before {
            content: '';
            display: block;
            width: 100px;
            font-size: 14px;
            color: #fff;
            line-height: 32px;
            text-align: center;
            opacity: 0;
            -webkit-transform: translate3d(0, 0, 0);
            -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-closed:hover:before {
            opacity: 1;
            display: block;
            -webkit-transform: translate3d(-100px, 0, 0);
            -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom,
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
            position: absolute;
            left: 0;
            height: 4px;
            width: 100%;
        }

        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom {
            background-color: #bd2355;;
        }

        .hamburger.is-closed .hamb-top {
            top: 5px;
            -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-closed .hamb-middle {

            top: 50%;
            margin-top: -2px;
        }

        .hamburger.is-closed .hamb-bottom {
            bottom: 5px;
            -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-closed:hover .hamb-top {
            top: 0;
            -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-closed:hover .hamb-bottom {
            bottom: 0;
            -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
            background-color: #bd2355;
        }

        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-bottom {
            top: 50%;
            margin-top: -2px;
        }

        .hamburger.is-open .hamb-top {
            -webkit-transform: rotate(45deg);
            -webkit-transition: -webkit-transform .2s cubic-bezier(.73, 1, .28, .08);
        }

        .hamburger.is-open .hamb-middle {
            display: none;
        }

        .hamburger.is-open .hamb-bottom {
            -webkit-transform: rotate(-45deg);
            -webkit-transition: -webkit-transform .2s cubic-bezier(.73, 1, .28, .08);
        }

        .hamburger.is-open:before {
            content: '';
            display: block;
            width: 100px;
            font-size: 14px;
            color: #fff;
            line-height: 32px;
            text-align: center;
            opacity: 0;
            -webkit-transform: translate3d(0, 0, 0);
            -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-open:hover:before {
            opacity: 1;
            display: block;
            -webkit-transform: translate3d(-100px, 0, 0);
            -webkit-transition: all .35s ease-in-out;
        }

        /*-------------------------------*/
        /*            Overlay            */
        /*-------------------------------*/

        .overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(250,250,250,.8);
            /*z-index: 1;*/
        }
    </style>
</head>
<body>

{{--<div id="mySidenav" class="sidenav">--}}
{{--<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>--}}
{{--<div  class="btn btn-info" data-toggle="collapse" data-target="#demo">Simple collapsible</div>--}}
{{--<div id="demo" class="collapse">--}}
{{--Lorem--}}
{{--</div>--}}
{{--</div>--}}
{{--<div id="wrapper">--}}
    {{--<div class="overlay"></div>--}}

    {{--<!-- Sidebar -->--}}
    {{--<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">--}}
        {{--<ul class="nav sidebar-nav">--}}
            {{--<li class="sidebar-brand">--}}
                {{--<a href="{{route('welcome')}}">--}}
                    {{--<img src="{{asset('images/logo.jpg')}}"  class="img-rounded" style=" width:30%;" alt="">--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="{{route('home')}}">Home</a>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">Customers <span class="caret"></span></a>--}}
                {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li class="dropdown-header">Dropdown heading</li>--}}
                    {{--<li><a href="{{route('dispatch.create')}}">Create Dispatch</a></li>--}}
                    {{--<li><a href="{{route('returns.create')}}">Return Dispatch</a></li>--}}
                    {{--<li><a href="{{route('dispatch.index')}}">All Dispatches</a></li>--}}
                    {{--<li><a href="{{route('returns.index')}}">All Return</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">WareHouse <span class="caret"></span></a>--}}
                {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li class="dropdown-header">Dropdown heading</li>--}}
                    {{--<li><a href="{{route('transfer.create')}}">Make a Transfer</a></li>--}}
                    {{--<li><a href="{{route('transfer.index')}}">All Transfer</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">Purchase<span class="caret"></span></a>--}}
                {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li class="dropdown-header">Dropdown heading</li>--}}
                    {{--<li><a href="{{route('purchase.create')}}">Create Purchase</a></li>--}}
                    {{--<li><a href="{{route('purchase.index')}}">Show Purchase</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">Freezer <span class="caret"></span></a>--}}
                {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li class="dropdown-header">Freezer - Menu</li>--}}
                    {{--<li><a href="{{route('freezer.create')}}">Transfer Freezer</a></li>--}}
                    {{--<li><a href="{{route('freezer.return')}}">Return Freezer</a></li>--}}
                    {{--<li><a href="{{route('freezer.index')}}">Show All</a></li>--}}
{{--                    <li><a href="{{route('returns.index')}}">All Return</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
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
            {{--<li>--}}
                {{--<a href="{{ route('logout') }}"--}}
                   {{--onclick="event.preventDefault();--}}
                                                     {{--document.getElementById('logout-form').submit();">--}}
                    {{--Logout--}}
                {{--</a>--}}
                {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                    {{--{{ csrf_field() }}--}}
                {{--</form>--}}
            {{--</li>--}}

        {{--</ul>--}}
    {{--</nav>--}}
    {{--<!-- /#sidebar-wrapper -->--}}

    {{--<!-- Page Content -->--}}
    {{--<div id="page-content-wrapper">--}}
        {{--<button type="button" class="hamburger is-closed" data-toggle="offcanvas">--}}
            {{--<span class="hamb-top"></span>--}}
            {{--<span class="hamb-middle"></span>--}}
            {{--<span class="hamb-bottom"></span>--}}
        {{--</button>--}}


    {{--</div>--}}
    <div id="wrapper">
        @include('includes.sidenav')

        <div class="col-md-offset-1 col-md-11">
            <div align="center" style="position: relative; top:-20px;color: #a0114e"><h3><strong>Asset Management System (BigBird Group)</strong></h3></div>
            @yield('content')
        </div>

    </div>
</div>


</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/utility.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
{{--<script>--}}
{{--function openNav() {--}}
{{--document.getElementById("mySidenav").style.width = "200px";--}}
{{--document.getElementById("main").style.marginLeft = "200px";--}}
{{--//        document.getElementById("main").class = "col-md-10";--}}

{{--}--}}

{{--function closeNav() {--}}
{{--document.getElementById("mySidenav").style.width = "0";--}}
{{--document.getElementById("main").style.marginLeft= "0";--}}

{{--}--}}

{{--</script>--}}


</html>
