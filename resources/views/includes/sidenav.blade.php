<div class="overlay"></div>

<!-- Sidebar -->
<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
    <ul class="nav sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{route('welcome')}}">
                <img src="{{asset('images/logo.jpg')}}"  class="img-rounded" style=" width:30%;" alt="">
            </a>
        </li>
        <li>
            <a href="{{route('home')}}">Home</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customers <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="dropdown-header">Dropdown heading</li>
                <li><a href="{{route('dispatch.create')}}">Create Dispatch</a></li>
                <li><a href="{{route('returns.create')}}">Return Disptach</a></li>
                <li><a href="{{route('dispatch.index')}}">All Disptaces</a></li>
                <li><a href="{{route('returns.index')}}">All Return</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">WareHouse <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="dropdown-header">Dropdown heading</li>
                <li><a href="{{route('transfer.create')}}">Make a Transfer</a></li>
                <li><a href="{{route('transfer.index')}}">All Transfer</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Purchase<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="dropdown-header">Dropdown heading</li>
                <li><a href="{{route('purchase.create')}}">Create Purchase</a></li>
                <li><a href="{{route('purchase.index')}}">Show Purchase</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Freezer <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="dropdown-header">Freezer - Menu</li>
                <li><a href="{{route('freezer.create')}}">Transfer Freezer</a></li>
                <li><a href="{{route('freezer.return')}}">Return Freezer</a></li>
                <li><a href="{{route('freezer.index')}}">Show All</a></li>
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

    </ul>
</nav>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-content-wrapper">
    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
        <span class="hamb-top"></span>
        <span class="hamb-middle"></span>
        <span class="hamb-bottom"></span>
    </button>


</div>