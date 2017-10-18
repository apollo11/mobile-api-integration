@extends('layouts.app')
@section('content')
    {{--<form id="approve-{{ $details->id }}" action="{{ route('job.approve',['id' => $details->id]) }}"--}}
          {{--method="POST" style="display: none;">--}}
        {{--{{ csrf_field() }}--}}
    {{--</form>--}}
    {{--<form id="reject-{{ $details->id }}" action="{{ route('employee.reject',['id' => $details->id]) }}"--}}
          {{--method="POST" style="display: none;">--}}
        {{--{{ csrf_field() }}--}}
        {{--<input type="submit" value="Reject">--}}
    {{--</form>--}}

    <div class="page-content-wrapper employee-details">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('employee.lists')  }}">Employees</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>View</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Employees</span>
                            </div>
                            <div class="actions">
                                <a class="btn sbold green"
                                   href="{{ route('employee.edit',['id' => $details->id])  }}">
                                    Update</a>

                                <a class="btn sbold green"
                                   href="{{ route('employee.approve',['id' => $details->id])  }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'approve-'.$details->id }}').submit();">
                                    Approve</a>
                                <a class="btn sbold green"
                                   href="{{ route('employee.reject',['id' => $details->id]) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'reject-'.$details->id }}').submit();">
                                    Reject
                                </a>
                                <input class="btn sbold green" name="multiple" onclick="window.print()" value="Print"
                                       type="submit"/>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group">
                                            <div class="col-md-4">Name</div>
                                            <div class="col-md-8">Testing</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered related-jobs">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Related Jobs</span>
                            </div>
                            {{ csrf_field() }}

                            <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                   id="employee-table">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="group-checkable"
                                                   data-set="#employee-table .checkboxes"/>
                                            <span></span>
                                        </label>
                                    </th>
                                    <th> Job Type</th>
                                    <th> Job Date</th>
                                    <th>Status</th>
                                    <th>Clients Name</th>
                                    <th>Hourly Rate</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr class="odd gradeX">
                                        <th>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </th>
                                        <td>Test</td>
                                        <td>Test</td>
                                        <td>Test</td>
                                        <td>Test</td>
                                        <td>Test</td>

                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="">
                                                            <i class="fa fa-trash"></i> Delete</a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <i class="fa fa-edit"></i> Edit </a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <i class="fa fa-eye"></i> View </a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <i class="fa fa-check-square-o"></i> Approve</a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <i class="fa fa-close"></i> Reject
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
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
@endsection