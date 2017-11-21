<?php $current_route = Request::route()->getName(); ?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
       
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To removle the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper hidden-xs">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search" action="extra_search.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            @if (Auth::user()->role_id == 0)
            <li class="start {{{ (Request::is('home') ? ' active' : '') }}}">
                <a href="{{ route('home') }}">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            @endif
            <li {{{ ($current_route == 'employee.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('employee.lists') }}">
                    <i class="fa fa-user"></i>
                    <span class="title">Employees</span>
                </a>
            </li>
             @if (Auth::user()->role_id == 0)
             <li {{{ ($current_route == 'employer.new.list' ? 'class=active' : '') }}}>
                <a href="{{ route('employer.new.list') }}">
                    <i class="fa fa-user"></i>
                    Registered Employers</a>
            </li>
             <li {{{ ($current_route == 'employer.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('employer.lists') }}">
                    <i class="icon-basket"></i>
                    Employers</a>
            </li>
             <li {{{ ($current_route == 'payout.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('payout.lists') }}">
                    <i class="icon-tag"></i>
                    Payouts</a>
            </li>
            @endif
            
             <li {{{ ($current_route == 'job.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('job.lists') }}">
                    <i class="icon-handbag"></i>
                    Job Management</a>
            </li>

             @if (Auth::user()->role_id == 0)
             <li {{{ ($current_route == 'industry.create' ? 'class=active' : '') }}}>
                <a href="{{ route('industry.create') }}">
                    <i class="icon-handbag"></i>
                    Industry</a>
            </li>
             <li {{{ ($current_route == 'location.create' ? 'class=active' : '') }}}>
                <a href="{{ route('location.create') }}">
                    <i class="icon-handbag"></i>
                    Location</a>
            </li>

            <li class="nav-item">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-line-chart"></i>
                                    <span class="title">Reports</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu" style="display: none;">
                                    <li class="nav-item  ">
                                        <a href="{{route('reports.weekly_report') }}" class="nav-link ">
                                            <span class="title">Weekly Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

            <li {{ ($current_route == 'mgt.list' ? 'class=active' : '') }}>
                <a href="{{ route('mgt.list') }}">
                    <i class="fa fa-user"></i>
                    <span class="title">Admin Users</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-settings"></i>
                    <span class="title">Push Notification</span>
                </a>
            </li>
            <li {{{ ($current_route == 'recipient.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('recipient.lists') }}">
                    <i class="icon-settings"></i>
                    <span class="title">Recipient Group</span>
                </a>
            </li>
            @endif

            <li {{{ (Request::is('settings') ? 'class=active' : '') }}}>
                <a href="{{route('settings') }}">
                    <i class="icon-settings"></i>
                    <span class="title">Settings</span>
                    
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <i class="icon-logout"></i>
                    <span class="title">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->
