<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AMS BigBird</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{asset('images/logo.jpg')}}">
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
<div id="wrapper">
    @include('includes.sidenav')
    <div >
        <div class="">
             <span align="center" >
                @if (Session::has('message'))
                     <div class="alert alert-info"  style ="background-color:red;color:white;font-weight: bolder;position:relative;z-index: 1;">{{ Session::get('message') }}</div>
                 @endif
                </span>
            <div class="">
                <img src="{{asset('images/loginbg.jpg')}}" id="bg" alt="">
                <div >
                    <span align="center" >
                        @if (Session::has('message'))
                            <div class="alert alert-info" style ="background-color:red;color:white;font-weight: bolder">{{ Session::get('message') }}</div>
                        @endif
                    </span>
                    <div class="container" style="margin: 0 0 0 250px;">

                        <div class="row">
                            <div class="  col-md-3">
                                <div class="thumbnail">
                                    <a href="{{route('dispatch.index')}}">
                                        <img src="{{asset('images/crates.jpg')}}"  alt="Crates-img" style="width:100%;height:190px">
                                        <div class="caption">
                                            <p >Crates Menu</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-offset-1 col-md-3">
                                <div class="thumbnail">
                                    <a href="{{route('freezer.index')}}" >
                                        <img src="{{asset('images/freezer.jpg')}}" alt="Freezer-img" style="width:100%;height:190px">
                                        <div class="caption">
                                            <p>Freezer Menu</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <a href="#" >

                                        <img src="{{asset('images/generator.jpg')}}" alt="Generator-img" style="width:100%;height:190px">
                                        <div class="caption">
                                            <p>Generator Menu</p>
                                        </div>
                                    </a>

                                </div>
                                <div class="transbox">
                                    <h2>Coming Soon</h2>
                                </div>
                            </div>
                            <div class=" col-md-offset-1 col-md-3">
                                <div class="thumbnail">
                                    <a href="{{route('transfer.index')}}" >
                                        <img src="{{asset('images/palette.jpg')}}" alt="Palette-img" style="width:100%;height:190px">

                                        <div class="caption">
                                            <p>Palette Menu</p>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>


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


