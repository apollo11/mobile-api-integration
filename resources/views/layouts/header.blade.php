<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/assets/pages/img/logo.png') }}" width="30px" height="20px" class="logo-default"/> </a>
            </a>
            <div class="menu-toggler sidebar-toggler hide">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->

        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>

        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default">
                    7 </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <p>
                                You have 14 new notifications
                            </p>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-success">
                                    <i class="fa fa-plus"></i>
                                    </span>
                                        New user registered. <span class="time">
                                    Just now </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-danger">
                                    <i class="fa fa-bolt"></i>
                                    </span>
                                        Server #12 overloaded. <span class="time">
                                    15 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-warning">
                                    <i class="fa fa-bell-o"></i>
                                    </span>
                                        Server #2 not responding. <span class="time">
                                    22 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-info">
                                    <i class="fa fa-bullhorn"></i>
                                    </span>
                                        Application error. <span class="time">
                                    40 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-danger">
                                    <i class="fa fa-bolt"></i>
                                    </span>
                                        Database overloaded 68%. <span class="time">
                                    2 hrs </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-danger">
                                    <i class="fa fa-bolt"></i>
                                    </span>
                                        2 user IP blocked. <span class="time">
                                    5 hrs </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-warning">
                                    <i class="fa fa-bell-o"></i>
                                    </span>
                                        Storage Server #4 not responding. <span class="time">
                                    45 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-info">
                                    <i class="fa fa-bullhorn"></i>
                                    </span>
                                        System Error. <span class="time">
                                    55 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <span class="label label-sm label-icon label-danger">
                                    <i class="fa fa-bolt"></i>
                                    </span>
                                        Database overloaded 68%. <span class="time">
                                    2 hrs </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="external">
                            <a href="#">
                                See all notifications <i class="m-icon-swapright"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END NOTIFICATION DROPDOWN -->

                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <?php $profileurl = Auth::user()->profile_image_path; 
                    if ($profileurl==null || $profileurl == ''){ $profileurl = 'avatars/default.png';} ?>
                        <img alt="" class="img-circle" src={{ url( $profileurl ) }} />

                        @if(!Auth::guest())
                        <span class="username username-hide-on-mobile"> {{  Auth::user()->role_id == 0 ? Auth::user()->name : Auth::user()->company_name }}</span>
                        @endif
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('myprofile') }}">
                                <i class="icon-user"></i> My Profile </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="icon-logout"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>


                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                {{--<li class="dropdown dropdown-quick-sidebar-toggler">--}}
                    {{--<a href="javascript:;" class="dropdown-toggle">--}}
                        {{--<i class="icon-logout"></i>--}}
                    {{--</a>--}}

                    {{--<a href="{{ route('logout') }}"--}}
                       {{--onclick="event.preventDefault();--}}
                                {{--document.getElementById('logout-form').submit();">--}}
                        {{--<i class="icon-key"></i> Log Out--}}
                    {{--</a>--}}
                    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                        {{--{{ csrf_field() }}--}}
                    {{--</form>--}}
                {{--</li>--}}
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->