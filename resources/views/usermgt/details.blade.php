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
                                                                @if(count($details->dashboard_permissions) >= 1)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-warning"> Disabled </button>

                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Employees Permission</strong></td>
                                                            <td>
                                                                @if(count($details->employees_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Employer Permission</strong></td>
                                                            <td>
                                                                @if(count($details->employers_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Job Mgt. Permission</strong></td>
                                                            <td>
                                                                @if(count($details->job_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Reports Permission</strong></td>
                                                            <td>
                                                                @if(count($details->job_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Push Notification Permission</strong></td>
                                                            <td>
                                                                @if(count($details->push_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Recipient Group Permission</strong></td>
                                                            <td>
                                                                @if(count($details->recipient_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Settings Permission</strong></td>
                                                            <td>
                                                                @if(count($details->settings_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Payout Permission</strong></td>
                                                            <td>
                                                                @if(count($details->payout_permissions) > 0)
                                                                    <button class="label label-sm label-success"> Enabled </button>
                                                                @else
                                                                    <button class="label label-sm label-danger"> disabled </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
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