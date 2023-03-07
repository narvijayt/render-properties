<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('img/default-avatar.png')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="active">
                <a href="{{url('/cpldashrbcs')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> New User
                        </a>
                    </li>
                    {{--<li>
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-circle-o"></i> All Users
                        </a>
                    </li>--}}
                    <li>
                        <a href="{{ url('cpldashrbcs/realtors') }}">
                            <i class="fa fa-circle-o"></i> Realtors
                        </a>
                    </li><li>
                        <a href="{{ url('cpldashrbcs/brokers') }}">
                            <i class="fa fa-circle-o"></i> Lenders
                        </a>
                    </li>
                    {{--<li>
                        <a href="{{ url('cpldashrbcs/paid-brokers') }}">
                            <i class="fa fa-circle-o"></i> Paid Lenders
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('cpldashrbcs/unpaid-brokers') }}">
                            <i class="fa fa-circle-o"></i> Unpaid Lenders
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('cpldashrbcs/consumers') }}">
                            <i class="fa fa-circle-o"></i> Consumers
                        </a>
                    </li>--}}
                    <li>
                        <a href="{{ url('cpldashrbcs/notify-users') }}">
                            <i class="fa fa-circle-o"></i> Notify Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('uploadedUsers') }}">
                            <i class="fa fa-circle-o"></i> Upload Users
                        </a>
                    </li>
                    <!-----<li>
                        <a href="{{ url('cpldashrbcs/all-matches') }}">
                            <i class="fa fa-circle-o"></i> All Matches
                        </a>
                    </li>--->
                </ul>
            </li>
            {{--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Vendor</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{url('cpldashrbcs/all-vendors')}}">
                            <i class="fa fa-circle-o"></i>All Vendors
                        </a>
                    </li>
                    <li>
                        <a href="{{url('cpldashrbcs/add-industry')}}">
                            <i class="fa fa-circle-o"></i>Add Industry
                        </a>
                    </li>
                    <li>
                        <a href="{{url('cpldashrbcs/all-industry')}}">
                            <i class="fa fa-circle-o"></i>All Industry
                        </a>
                    </li>
                </ul>
            </li>
            --}}
            
            
            <!----<li class="treeview">
                <a href="#">
                    <i class="fa fa-user-o"></i>
                    <span>Add Designation</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{url('cpldashrbcs/add-designation')}}">
                            <i class="fa fa-circle-o"></i>Add Designation
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('cpldashrbcs/users-with-designation') }}">
                            <i class="fa fa-circle-o"></i> Users
                        </a>
                    </li>
                </ul>
            </li>-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-text"></i>
                    <span>Pages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{url('cpldashrbcs/pages')}}">
                            <i class="fa fa-circle-o"></i>All Pages
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-text"></i>
                    <span>Blogs</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{url('cpldashrbcs/blogs')}}">
                            <i class="fa fa-circle-o"></i>All Blogs
                        </a>
                    </li>
                    <li>
                        <a href="{{url('cpldashrbcs/taxonomies')}}">
                            <i class="fa fa-circle-o"></i>All Categories
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{url('cpldashrbcs/testimonials')}}">
                    <i class="fa fa-comments"></i>Testimonials
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-cogs"></i><span>Settings</span>
                </a>
            </li>
        </ul>
    </section>
</aside>