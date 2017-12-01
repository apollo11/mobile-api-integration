<?php 

/*Menu highlight*/
$current_route = Request::route()->getName(); 

$employee_navarr = array('employee.lists', 'employee.create','employee.details','employee.edit');
$employer_navarr = array('employer.lists', 'employer.new.list','employer.create', 'employer.details','employer.edit');
$jobs_navarr = array('job.lists','job.create', 'job.details','job.edit','job.location_tracking');
$industry_navarr = array('industry.lists','industry.create', 'industry.details','industry.edit');
$location_navarr = array('location.lists','location.create', 'location.details','location.edit');
$mgt_navarr = array('mgt.lists','mgt.create', 'mgt.details','mgt.edit');
$pushnotification_navarr = array('pushnotification.lists','pushnotification.create', 'pushnotification.details','pushnotification.edit','pushnotification.quickNotification');
$recipient_navarr = array('recipient.lists','recipient.create', 'recipient.details','recipient.edit');

/*Menu highlight end*/
?>
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
                <div class="sidebar-toggler hide">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            @can('dashboard-view')
                <li class="start {{{ ((Request::is('home') || Request::is('/')) ? ' active' : '') }}}">
                    <a href="{{ route('home') }}">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan
            @can('employee-view')
                <li {{{ (  in_array($current_route,$employee_navarr)  ? 'class=active' : '') }}}>
                    <a href="{{ route('employee.lists') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">Employees</span>
                    </a>
                </li>
            @endcan
             
            @if (Auth::user()->role_id == 0)
                 @can('employer-view')
                    <li class="nav-item {{{ (    in_array($current_route,$employer_navarr) ? ' active open' : '') }}}">
                        <a href="javascript:;" class="nav-link nav-toggle ">
                             <i class="fa fa-user"></i>
                            <span class="title">Employers</span>
                            <span class="arrow {{{ (    in_array($current_route,$employer_navarr) ? ' open' : '') }}}"></span>
                        </a>
                        <ul class="sub-menu"  {{{ ( !in_array($current_route,$employer_navarr) ? 'style="display: none;"' : '') }}} >
                            <li class="nav-link {{{ (   ($current_route != 'employer.new.list' && in_array($current_route,$employer_navarr) ) ? ' active' : '') }}} ">
                                <a href="{{ route('employer.lists') }}">Employers</a>
                            </li>
                            <li class="nav-link {{{ ($current_route == 'employer.new.list' ? ' active' : '') }}}">
                                <a href="{{ route('employer.new.list') }}">Registered Employers</a>
                            </li>
                        </ul>
                    </li>
                 @endcan

                 @can('payout-view')
                     <li {{{ ($current_route == 'payout.lists' ? 'class=active' : '') }}}>
                        <a href="{{ route('payout.lists') }}">
                            <i class="fa fa-usd"></i>
                            Payouts</a>
                    </li>
                 @endcan
            @endif

            @can('job-view')
             <li {{{ (in_array($current_route,$jobs_navarr) ? 'class=active' : '') }}}>
                <a href="{{ route('job.lists') }}"><i class="fa fa-tasks"></i> Job Management</a>
            </li>
            @endcan

             @if (Auth::user()->role_id == 0)
                @can('admin-view')
                <li {{{ ( in_array($current_route,$industry_navarr) ? 'class=active' : '') }}}>
                    <a href="{{ route('industry.lists') }}">
                        <i class="fa fa-industry"></i>
                        Industry</a>
                </li>
                @endcan

                @can('admin-view')
                 <li {{{ ( in_array($current_route, $location_navarr ) ? 'class=active' : '') }}}>
                    <a href="{{ route('location.lists') }}">
                        <i class="fa fa-globe"></i>
                        Location</a>
                </li>
                @endcan

                @can('reports-view')
                <li class="nav-item {{{ ($current_route == 'reports.weekly_report' ? ' active open' : '') }}}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-line-chart"></i>
                        <span class="title">Reports</span>
                        <span class="arrow {{{ ($current_route == 'reports.weekly_report' ? ' open' : '') }}}"></span>
                    </a>
                    <ul class="sub-menu"  {{{ ($current_route != 'reports.weekly_report' ? 'style="display: none;"' : '') }}} >
                        <li class="nav-item  {{{ ($current_route == 'reports.weekly_report' ? ' active' : '') }}}">
                            <a href="{{route('reports.weekly_report') }}" class="nav-link ">
                                <span class="title">Weekly Report</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('admin-view')
                     <li {{ ( in_array($current_route,$mgt_navarr)  ? 'class=active' : '') }}>
                        <a href="{{ route('mgt.list') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">Admin Users</span>
                        </a>
                    </li>
                @endcan
                @can('push-view')
                 <li {{{ (  in_array($current_route,$pushnotification_navarr) ? 'class=active' : '') }}}>
                    <a href="{{ route('pushnotification.lists') }}">
                        <i class="fa fa-comment"></i>
                        <span class="title">Push Notification</span>
                    </a>
                </li>
                @endcan
                @can('recipient-view')
                    <li {{{ ( in_array($current_route,$recipient_navarr) ? 'class=active' : '') }}}>
                        <a href="{{ route('recipient.lists') }}">
                            <i class="fa fa-users"></i>
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
