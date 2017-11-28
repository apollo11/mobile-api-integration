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
            @if (Auth::user()->role_id == 0)
                @can('dashboard-view')
                    <li class="start {{{ ((Request::is('home') || Request::is('/')) ? ' active' : '') }}}">
                        <a href="{{ route('home') }}">
                            <i class="icon-home"></i>
                            <span class="title">Dashboard</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endcan
            @endif
            @can('employee-view')
                <li {{{ ($current_route == 'employee.lists' ? 'class=active' : '') }}}>
                    <a href="{{ route('employee.lists') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">Employees</span>
                    </a>
                </li>
            @endcan
             @if (Auth::user()->role_id == 0)
                 @can('employer-view')
                     <li {{{ ($current_route == 'employer.new.list' ? 'class=active' : '') }}}>
                        <a href="{{ route('employer.new.list') }}">
                            <i class="fa fa-user"></i>
                            Registered Employers</a>
                    </li>
                @endcan
                @can('employer-view')
                 <li {{{ ($current_route == 'employer.lists' ? 'class=active' : '') }}}>
                    <a href="{{ route('employer.lists') }}">
                        <i class="icon-basket"></i>
                        Employers</a>
                </li>
                 @endcan
             @can('payout-view')
                 <li {{{ ($current_route == 'payout.lists' ? 'class=active' : '') }}}>
                    <a href="{{ route('payout.lists') }}">
                        <i class="icon-tag"></i>
                        Payouts</a>
                </li>
             @endcan
            @endif
            @can('job-view')
             <li {{{ ($current_route == 'job.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('job.lists') }}">
                    <i class="icon-handbag"></i>
                    Job Management</a>
            </li>
            @endcan

             @if (Auth::user()->role_id == 0)
                @can('admin-view')
                <li {{{ ($current_route == 'industry.lists' ? 'class=active' : '') }}}>
                    <a href="{{ route('industry.lists') }}">
                        <i class="icon-handbag"></i>
                        Industry</a>
                </li>
                @endcan
            @can('admin-view')
             <li {{{ ($current_route == 'location.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('location.lists') }}">
                    <i class="icon-handbag"></i>
                    Location</a>
            </li>
            @endcan

            @can('reports-view')
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
            @endcan
            @can('admin-view')
                 <li {{ ($current_route == 'mgt.list' ? 'class=active' : '') }}>
                    <a href="{{ route('mgt.list') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">Admin Users</span>
                    </a>
                </li>
            @endcan
            @can('push-view')
             <li {{{ ($current_route == 'pushnotification.lists' ? 'class=active' : '') }}}>
                <a href="{{ route('pushnotification.lists') }}">
                    <i class="icon-settings"></i>
                    <span class="title">Push Notification</span>
                </a>
            </li>
            @endcan
            @can('recipient-view')
                <li {{{ ($current_route == 'recipient.lists' ? 'class=active' : '') }}}>
                    <a href="{{ route('recipient.lists') }}">
                        <i class="icon-settings"></i>
                        <span class="title">Recipient Group</span>
                    </a>
                </li>
            @endcan
            @endif

            @if (Auth::user()->role_id == 0)
            @can('settings-view')
                <li {{{ (Request::is('settings') ? 'class=active' : '') }}}>
                    <a href="{{route('settings') }}">
                        <i class="icon-settings"></i>
                        <span class="title">Settings</span>

                    </a>
                </li>
            @endcan
            @endif
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
