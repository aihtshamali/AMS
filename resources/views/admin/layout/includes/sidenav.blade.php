{{-- Side Navigation --}}
<div class="col-md-2">
    <div class="sidebar content-box" style="display: block;">
        <ul class="nav">
            <!-- Main menu -->
            <li class="current"><a href="{{route('admin.index')}}"><i class="glyphicon glyphicon-home"></i>
                    Dashboard</a></li>
            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-list"></i> Permissions
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('permission.create')}}"><i
                                    class="glyphicon glyphicon-home"></i>
                            Add new Permisions</a></li>
                </ul>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('permission.index')}}"><i
                                    class="glyphicon glyphicon-home"></i>
                            All Permissions</a></li>
                </ul>
            </li>

            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-list"></i> Users & Permissions
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->

                <ul>
                    <li class="sub-menu"><a href="{{route('register')}}"><i class="glyphicon glyphicon-home"></i>
                            Add new User</a></li>
                </ul>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('showusers')}}"><i class="glyphicon glyphicon-user"></i>
                            All Users</a></li>
                </ul>


            </li>
            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-home"></i> City
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->

                <ul>
                    <li class="sub-menu"><a href="{{route('city.create')}}"><i class="glyphicon glyphicon-home"></i>
                            Add new City</a></li>
                </ul>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('city.index')}}"><i class="glyphicon glyphicon-user"></i>
                            All Cities</a></li>
                </ul>


            </li>

            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-home"></i> Items
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->

                <ul>
                    <li class="sub-menu"><a href="{{route('item.create')}}"><i class="glyphicon glyphicon-home"></i>
                            Add new Item</a></li>
                </ul>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('item.index')}}"><i class="glyphicon glyphicon-user"></i>
                            All Items</a></li>
                </ul>


            </li>
            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-home"></i> Regions
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->

                <ul>
                    <li class="sub-menu"><a href="{{route('region.create')}}"><i class="glyphicon glyphicon-home"></i>
                            Add new Region</a></li>
                </ul>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('region.index')}}"><i class="glyphicon glyphicon-user"></i>
                            All Regions</a></li>
                </ul>


            </li>
            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-home"></i> Faculty
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->

                <ul>
                    <li class="sub-menu"><a href="{{route('faculty.create')}}"><i class="glyphicon glyphicon-home"></i>
                            Add new Faculty</a></li>
                </ul>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('faculty.index')}}"><i class="glyphicon glyphicon-user"></i>
                            All Faculty</a></li>
                </ul>


            </li>


            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-list"></i> Customer
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('customer.create')}}"><i class="glyphicon glyphicon-home"></i>
                            Add new Customer</a></li>
                </ul>
                <!-- Sub menu -->
                <ul>
                    <li class="sub-menu"><a href="{{route('customer.index')}}"><i class="glyphicon glyphicon-home"></i>
                            Show All Customers</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
