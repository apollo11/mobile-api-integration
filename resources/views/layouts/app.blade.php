<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="{{ app()->getLocale() }}"> <!--<![endif]-->

    <!-- BEGIN HEAD -->

    <head>
    <meta charset="utf-8">
    <title>YYJobs</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="YYJOBS Description"/>
    <meta content="" name="YYJOBS"/>
        <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <link href="{{ asset('assets/global/plugins/Gritter/css/jquery.gritter.css') }}" rel="stylesheet" type="text/css"/>

        <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/global/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL PLUGIN STYLES -->

        <!-- BEGIN PAGE STYLES -->
        <link href="{{ asset('assets/pages/css/tasks.css') }}" rel="stylesheet" type="text/css"/>
        <!-- END PAGE STYLES -->


        <!-- BEGIN THEME STYLES -->
        <link href="{{ asset('assets/global/css/components.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/layouts/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/pages/css/login.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/layouts/layout/css/themes/darkblue.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="{{ asset('assets/layouts/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>

        <!-- <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

        <!-- <link href="{{ asset('assets/bootstrap-multiselect.min.css') }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('assets/bootstrap-multiselect.min.js') }}" type="text/javascript"></script> -->

        <!-- page level javascripts -->
           @yield ('custom_page_css')
        <!-- end page level javascripts -->

        <!-- END THEME STYLES -->
</head>
    <!-- END HEAD -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <div class="page-wrapper">
        {{--<nav class="navbar navbar-default navbar-static-top">--}}
            {{--<div class="container">--}}
                {{--<div class="navbar-header">--}}

                    {{--<!-- Collapsed Hamburger -->--}}
                    {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">--}}
                        {{--<span class="sr-only">Toggle Navigation</span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                    {{--</button>--}}

                    {{--<!-- Branding Image -->--}}
                    {{--<a class="navbar-brand" href="{{ url('/') }}">--}}
                        {{--YYJobs--}}
                    {{--</a>--}}
                {{--</div>--}}

                {{--<div class="collapse navbar-collapse" id="app-navbar-collapse">--}}
                    {{--<!-- Left Side Of Navbar -->--}}
                    {{--<ul class="nav navbar-nav">--}}
                        {{--&nbsp;--}}
                    {{--</ul>--}}

                    {{--<!-- Right Side Of Navbar -->--}}
                    {{--<ul class="nav navbar-nav navbar-right">--}}
                        {{--<!-- Authentication Links -->--}}
                        {{--@if (Auth::guest())--}}
                            {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
                            {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                        {{--@else--}}
                            {{--<li class="dropdown">--}}
                                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                                    {{--{{ Auth::user()->name }} <span class="caret"></span>--}}
                                {{--</a>--}}

                                <ul class="dropdown-menu" role="menu">
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
                            {{--</li>--}}
                        {{--@endif--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</nav>--}}
        @if (!Auth::guest())
                <div class="page-header navbar navbar-fixed-top">
                    @include('layouts.header')
                </div>
                <div class="clearfix"> </div>
        @endif


    <div class="page-container">
            @if(!Auth::guest())
              @include('layouts.sidebar')
            @endif

           @yield('content')
    </div>
    <div class="page-footer">
        @include('layouts.footer')
    </div>


    </div>

    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/global/plugins/respond.min.js') }}"></sdatatcript>
    <script src="{{ asset('assets/global/plugins/excanvas.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/ie8.fix.min.js') }}"></script>
    <![endif]-->

    <script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>

    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{ asset('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>


    <script src="{{ asset('assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/counterup/jquery.counterup.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/amcharts/amcharts/serial.js')  }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/amcharts/amcharts/pie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/amcharts/amcharts/radar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/amcharts/amcharts/themes/patterns.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/amcharts/amcharts/themes/chalk.js') }}" type="text/javascript"></script>
    <!-- <script src="{{ asset('assets/global/plugins/amcharts/ammap/ammap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/amcharts/ammap/maps/js/worldLow.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('assets/global/plugins/amcharts/amstockcharts/amstock.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/horizontal-timeline/horizontal-timeline.js') }}" type="text/javascript"></script>

   <!--  <script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>
    <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
    <script src="{{ asset('assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    {{--<script src="{{ asset('assets/global/scripts/app.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/layouts/layout/scripts/layout.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/layouts/global/scripts/quick-nav.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/layouts/layout5/scripts/index.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/pages/scripts/tasks.js') }}" type="text/javascript"></script>--}}
    <!-- END PAGE LEVEL SCRIPTS -->

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/ui-bootbox.min.js') }}" type="text/javascript"></script>
    {{--<script src="{{ asset('assets/pages/scripts/ui-general.min.js') }}" type="text/javascript"></script>--}}
    <!-- END THEME GLOBAL SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('assets/pages/scripts/ui-modals.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
    
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ asset('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
    {{--<script src="{{ asset('assets/layouts/layout/scripts/demo.min.js')  }}" type="text/javascript"></script>--}}
    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });

            $(function () {
                $('#start-date').datetimepicker();
                $('#end-date').datetimepicker();
                $('#school-expiry-date').datetimepicker();
                $('#birthdate').datetimepicker();
            });

            // $("#myModal").on("show", function() {    // wire up the OK button to dismiss the modal when shown
            //     $("#myModal a.btn").on("click", function(e) {
            //         console.log("button pressed");   // just as an example...
            //         $("#myModal").modal('hide');     // dismiss the dialog
            //     });
            // });
            
            // $("#myModal").on("hide", function() {    // remove the event listeners when the dialog is dismissed
            //     $("#myModal a.btn").off("click");
            // });

            // $("#myModal").on("hidden", function() {  // remove the actual elements from the DOM when fully hidden
            //     $("#myModal").remove();
            // });

            $("#profile-img").modal({                    // wire up the actual modal functionality and show the dialog
                "backdrop"  : "static",
                "keyboard"  : true,
                "show"      : false                     // ensure the modal is shown immediately
            });

            $("#profile-img"
                , "#profile-front-ic"
                , "#profile-back-ic"
                , "#profile-bank-statement"
                , "#job-assigned"
            ).modal({                    // wire up the actual modal functionality and show the dialog
                "backdrop"  : "static",
                "keyboard"  : true,
                "show"      : false                     // ensure the modal is shown immediately
            });
        });

        //select all checkboxes
        $(".group-checkable").change(function(){  //"select all" change
            $(".checkboxes").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status

        });

        $(".manager-checkable").change(function(){  //"select all" change
            $(".check-manager").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        $(".employer-checkable").change(function(){  //"select all" change
            $(".check-employer").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

    </script>

    <script type="text/javascript">
        @if ($errors->has('profile_image'))
            $('#profile-img').modal('show');
        @endif

        @if ($errors->has('profile_front_ic'))
            $('#profile-front-ic').modal('show');
        @endif

        @if ($errors->has('profile_back_ic'))
            $('#profile-back-ic').modal('show');
        @endif

        @if ($errors->has('bank_statement'))
        $('#profile-bank-statement').modal('show');
        @endif

        @if ($errors->has('user_assign'))
        $('#job-assigned').modal('show');
        @endif
    </script>


    <script>
        jQuery(document).ready(function() {
            App.init(); // init metronic core componets
           // Layout.init(); // init layout
            QuickSidebar.init(); // init quick sidebar
//            Index.init();
//            Index.initDashboardDaterange();
//            Index.initJQVMAP(); // init index page's custom scripts
//            Index.initCalendar(); // init index page's custom scripts
//            Index.initCharts(); // init index page's custom scripts
//            Index.initChat();
//            Index.initMiniCharts();
//            Index.initIntro();
//            Tasks.initDashboardWidget();
        });
    </script>
    <!-- END JAVASCRIPTS -->


<!-- page level javascripts -->
   @yield ('custom_page_js')
<!-- end page level javascripts -->

</body>
</html>
