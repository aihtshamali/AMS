<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AMS BigBird</title>
        <link rel="icon" href="{{asset('images/logo.jpg')}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    <div class="" >
        <div class="    " >
            @if (Route::has('login'))
                <div class="top-right links"  >
                    @if (Auth::check())
                        <a href="{{ url('/home') }}" >Home</a>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @else
                        <a href="{{ url('/login') }}" >Login</a>
                        {{--<a href="{{ url('/register') }}">Register</a>--}}
                    @endif
                </div>
            @endif
        </div>
            <div class="">
                {{--<div class="title m-b-md">--}}
                    {{--Laravel--}}
                {{--</div>--}}
                <div align="center" style="border-bottom: 1px solid #1B1D4D">
                    <h3 style="padding-left:150px;margin-top: 13px">Assets Management System</h3>
                </div>
                </div>
    </div>
                <div >
                    <span align="center" >
                        @if (Session::has('message'))
                            <div class="alert alert-info" style ="background-color:red;color:white;font-weight: bolder">{{ Session::get('message') }}</div>
                        @endif
                    </span>
                    <div class="container" style="padding-top:60px;">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <a href="{{route('freezer.index')}}" >
                                        <img src="{{asset('images/freezer.jpg')}}" alt="Freezer-img" style="width:100%;height:190px">
                                        <div class="caption">
                                            <p>Freezer Menu</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class=" col-md-offset-0 col-md-3">
                                <div class="thumbnail">
                                    <a href="{{route('dispatch.index')}}">
                                        <img src="{{asset('images/crates.jpg')}}"  alt="Crates-img" style="width:100%;height:190px">
                                        <div class="caption">
                                            <p >Crates Menu</p>
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
                            <div class=" col-md-offset-0 col-md-3">
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

        <div class="footer-bottom">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div class="copyright" align="center">

                            © 2017-18, BIGBIRDS GROUP, All rights reserved

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </body>
</html>
