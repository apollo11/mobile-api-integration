<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
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
            <li class="start active ">
                <a href="/home">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('employee.lists') }}">
                    <i class="icon-basket"></i>
                    <span class="title">Employees</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li>
                <a href="{{ route('employer.new.list') }}">
                    <i class="icon-home"></i>
                    Newly Employers</a>
            </li>
            <li>
                <a href="{{ route('employer.lists') }}">
                    <i class="icon-basket"></i>
                    Employers</a>
            </li>
            <li>
                <a href="ecommerce_orders_view.html">
                    <i class="icon-tag"></i>
                    Payouts</a>
            </li>
            <li>
                <a href="{{ route('job.lists') }}">
                    <i class="icon-handbag"></i>
                    Job Management</a>
            </li>
            <li>
                <a href="{{ route('industry.create') }}">
                    <i class="icon-handbag"></i>
                    Industry</a>
            </li>
            <li>
                <a href="{{ route('location.create') }}">
                    <i class="icon-handbag"></i>
                    Location</a>
            </li>

            <li>
                <a href="ecommerce_products_edit.html">
                    <i class="icon-pencil"></i>
                    Report</a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-puzzle"></i>
                    <span class="title">Admin Users</span>
                    <span class="arrow "></span>
                </a>

            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-settings"></i>
                    <span class="title">Push Notification</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-logout"></i>
                    <span class="title">Settings</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <i class="icon-key"></i>
                    <span class="title">Logout</span>
                    <span class="arrow "></span>
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