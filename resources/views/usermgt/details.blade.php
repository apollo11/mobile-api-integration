@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper employee-details">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('employer.lists')  }}">Employers</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>View</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Employer Details</span>
                            </div>
                            <div class="actions">
                                <a class="btn sbold green"
                                   href="{{ route('mgt.edit',['id' => $details->id])  }}">
                                    Update</a>
                                <input class="btn sbold green" name="multiple" onclick="window.print()" value="Print"
                                       type="submit"/>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group">
                                            <div class="portlet-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            <td> <strong>Name</strong></td>
                                                            <td> {{ $details->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Email Address</strong></td>
                                                            <td> {{ $details->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Role</strong></td>
                                                            <td> {{ $details->role }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Employer</strong></td>
                                                            <td> {{ $details->employer }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Contact No.</strong></td>
                                                            <td> {{ $details->mobile_no }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Dashboard Permission</strong></td>
                                                            <td>
                                                                {{ empty($dashboard[0])  ? '' : $dashboard[0] }} ,
                                                                {{ empty($dashboard[1])  ? '' : $dashboard[1] }} ,
                                                                {{ empty($dashboard[2])  ? '' : $dashboard[2] }} ,
                                                                {{ empty($dashboard[3])  ? '' : $dashboard[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Employees Permission</strong></td>
                                                            <td>
                                                                {{ empty($employees[0])  ? '' : $employees[0] }} ,
                                                                {{ empty($employees[1])  ? '' : $employees[1] }} ,
                                                                {{ empty($employees[2])  ? '' : $employees[2] }} ,
                                                                {{ empty($employees[3])  ? '' : $employees[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Employees Permission</strong></td>
                                                            <td>
                                                                {{ empty($employers[0])  ? '' : $employers[0] }} ,
                                                                {{ empty($employers[1])  ? '' : $employers[1] }} ,
                                                                {{ empty($employers[2])  ? '' : $employers[2] }} ,
                                                                {{ empty($employers[3])  ? '' : $employers[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Job Mgt. Permission</strong></td>
                                                            <td>
                                                                {{ empty($job[0])  ? '' : $job[0] }} ,
                                                                {{ empty($job[1])  ? '' : $job[1] }} ,
                                                                {{ empty($job[2])  ? '' : $job[2] }} ,
                                                                {{ empty($job[3])  ? '' : $job[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Reports Permission</strong></td>
                                                            <td>
                                                                {{ empty($reports[0])  ? '' : $reports[0] }} ,
                                                                {{ empty($reports[1])  ? '' : $reports[1] }} ,
                                                                {{ empty($reports[2])  ? '' : $reports[2] }} ,
                                                                {{ empty($reports[3])  ? '' : $reports[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Push Notification Permission</strong></td>
                                                            <td>
                                                                {{ empty($push[0])  ? '' : $push[0] }} ,
                                                                {{ empty($push[1])  ? '' : $push[1] }} ,
                                                                {{ empty($push[2])  ? '' : $push[2] }} ,
                                                                {{ empty($push[3])  ? '' : $push[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Recipient Group Permission</strong></td>
                                                            <td>
                                                                {{ empty($recipient[0])  ? '' : $recipient[0] }} ,
                                                                {{ empty($recipient[1])  ? '' : $recipient[1] }} ,
                                                                {{ empty($recipient[2])  ? '' : $recipient[2] }} ,
                                                                {{ empty($recipient[3])  ? '' : $recipient[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Settings Permission</strong></td>
                                                            <td>
                                                                {{ empty($settings[0])  ? '' : $settings[0] }} ,
                                                                {{ empty($settings[1])  ? '' : $settings[1] }} ,
                                                                {{ empty($settings[2])  ? '' : $settings[2] }} ,
                                                                {{ empty($settings[3])  ? '' : $settings[3] }} ,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Payout Permission</strong></td>
                                                            <td>
                                                                {{ empty($payout[0])  ? '' : $payout[0] }} ,
                                                                {{ empty($payout[1])  ? '' : $payout[1] }} ,
                                                                {{ empty($payout[2])  ? '' : $payout[2] }} ,
                                                                {{ empty($payout[3])  ? '' : $payout[3] }} ,
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{--<div class="col-md-6">--}}
                                    {{--<div class="btn-group">--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12">--}}
                                    {{--<img class="img-circle" src="/{{ $employer->profile_image_path }}" height="80px"/>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.employee-datatables-include')