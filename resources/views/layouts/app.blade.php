<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header ><h1  style="display: inline;"><strong >Assets Management System</strong></h1>
            <span class="pull-right">
                <h6>Welcome: User-Name</h6>
                <h6 style="display: block">Location: Location</h6>
            </span>
        </header>
        <nav class="navbar navbar-default navbar-static-top navbar-inner">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-header" href="{{ url('/') }}">
                        {{--{{ config('app.name', 'Laravel') }}--}}
                        <img class="img-circle" width="30%"  src="{{ asset('images/logo.jpg') }}" >
                    </a>
                </div>
                <div class="collapse navbar-collapse"  id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Dispatch
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Add Dispatch</a></li>
                                <li><a href="#">All Dispatch</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Freezer
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Add Freezer</a></li>
                                <li><a href="#">All Freezer</a></li>
                                <li><a href="#">Return</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Return
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Add Return</a></li>
                                <li><a href="#">All Return</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Transfer
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Transfer Shiped</a></li>
                                <li><a href="#">Transfer in Transit</a></li>
                                <li><a href="#">Transfer Recieved</a></li>
                                <li><a href="#">Purchases</a></li>
                                <li><a href="#">All Purchases</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">location Base Stock Balance</a></li>
                                <li><a href="#">Customer-Wise Balance</a></li>
                                <li><a href="#">All Customer</a></li>
                            </ul>
                        </li>
                    </ul>



                <div class="collapse navbar-collapse " id="app-navbar-collapse"  style="display: inline;">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right " style="display: inline;">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown ">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu " role="menu">
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
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
                </div>
            </div>
    </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
