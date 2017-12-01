@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
          
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{route('home')}}">Dashboard</a>
                    </li>
                </ul>
                
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">  </h1>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
            @if($role_id==0 || $role_id==1 )
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ route('job.lists') }}?status=pending" class="dashboard-stat dashboard-stat-v2 blue" href="#">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $jobRequest }}">{{ $jobRequest }}</span>
                            </div>
                            <div class="desc">No. of New Job Requests</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ route('job.lists') }}?status=active" class="dashboard-stat dashboard-stat-v2 red" href="#">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $approved }}">{{ $approved }}</span>
                            </div>
                            <div class="desc">No of Jobs Approved</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ route('job.lists') }}?status=unassigned" class="dashboard-stat dashboard-stat-v2 green" href="#">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $unassigned }}">{{ $unassigned }}</span>
                            </div>
                            <div class="desc">No. of Jobs Unassigned</div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                @if (isset($pending_payout))
                    <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ route('payout.lists') }}?payment-status=pending">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{$pending_payout}}">{{$pending_payout}}</span>
                            </div>
                            <div class="desc">Pending Salary Transfers</div>
                        </div>
                    </a>
                @else
                    <div class="dashboard-stat dashboard-stat-v2 ">
                        <div class="visual">&nbsp;</div>
                        <div class="details">&nbsp;</div>
                    </div>
                @endif
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <a href="{{ route('employee.lists') }}?checkin=true" class="dashboard-stat dashboard-stat-v2 blue" href="#"> -->
                    <div class="dashboard-stat dashboard-stat-v2 blue">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $checkin }}">{{ $checkin }}</span>
                            </div>
                            <div class="desc"> Checked In jobseekers today</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <a href="{{ route('employee.lists') }}?checkout=true" class="dashboard-stat dashboard-stat-v2 red" > -->
                    <div class="dashboard-stat dashboard-stat-v2 red">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $checkout }}">{{ $checkout }}</span>
                            </div>
                            <div class="desc"> Checked out jobseekers today</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <a href="{{ route('employee.lists') }}?status=cancelled" class="dashboard-stat dashboard-stat-v2 green"> -->
                    <div class="dashboard-stat dashboard-stat-v2 green">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $cancelled }}">{{ $cancelled }}</span>
                            </div>
                            <div class="desc">No. of Cancellation by jobseeker</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @if (isset($registeredEmployer))
                    <a href="{{ route('employer.new.list') }}" class="dashboard-stat dashboard-stat-v2 purple" href="#">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $registeredEmployer }}">{{ $registeredEmployer }}</span>
                            </div>
                            <div class="desc">No. of Registered Employers on mobile</div>
                        </div>
                    </a>
                    @else
                        <div class="dashboard-stat dashboard-stat-v2 ">
                            <div class="visual">&nbsp;</div>
                            <div class="details">&nbsp;</div>
                        </div>
                    @endif
                </div>
            @else
                <div class="col-md-12">
                <blockquote>
                    Welcome back! 
                </blockquote>
                </div>
            @endif
            </div>
            <div class="clearfix"></div>
            <!-- END DASHBOARD STATS 1-->

                </div>
            </div>
        </div>
    </div>
@endsection
