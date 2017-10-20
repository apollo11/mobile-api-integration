@extends('layouts.app')

@section('content')
    <form id="approve-{{ $employer->id }}"
          action="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Approve']) }}"
          method="POST" style="display: none;">
        <input type="submit" value="Approve">
        {{ csrf_field() }}
    </form>
    <form id="reject-{{ $employer->id }}"
          action="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Reject']) }}"
          method="POST" style="display: none;">
        {{ csrf_field() }}
        <input type="submit" value="Reject">
    </form>
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
                <div class="col-md-6">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Employer Details</span>
                            </div>
                            <div class="actions">
                                <a class="btn sbold green"
                                   href="{{ route('employee.edit',['id' => $employer->id])  }}">
                                    Update</a>

                                <a class="btn sbold green"
                                   href="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Approve'])  }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'approve-'.$employer->id }}').submit();">
                                    Approve</a>
                                <a class="btn sbold green"
                                   href="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Reject']) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'reject-'.$employer->id }}').submit();">
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <img src="{{ $employer->profile_image_path }}"/></div>
                                            </div>

                                        <div class="row">
                                            <div class="col-md-4">Company Name</div>
                                            <div class="col-md-8"> {{ $employer->company_name }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">Business Manager</div>
                                            <div class="col-md-8"> {{ $employer->business_manager }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">Status</div>
                                            @if($employer->status == 0 )
                                                <td><span class="label label-sm label-warning"> Pending </span></td>
                                            @elseif($employer->status == 1)
                                                <td><span class="label label-sm label-success"> Approve </span></td>
                                            @elseif($employer->status == 2)
                                                <td><span class="label label-sm label-warning"> Upload </span></td>
                                            @else
                                                <td><span class="label label-sm label-danger"> Reject </span></td>
                                            @endif
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

                                {{--@foreach($jobInfo as $jobs)--}}
                                    {{--<tr class="odd gradeX">--}}
                                        {{--<th>--}}
                                            {{--<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">--}}
                                                {{--<input type="checkbox" class="group-checkable"--}}
                                                       {{--data-set="#employee-table .checkboxes"/>--}}
                                                {{--<span></span>--}}
                                            {{--</label>--}}
                                        {{--</th>--}}
                                        {{--<td>{{ $jobs->job_title }}</td>--}}
                                        {{--<td>{{ $jobs->start_date }}</td>--}}
                                        {{--<td> {{ $jobs->schedule_status }}</td>--}}
                                        {{--<td> {{ $jobs->company_name }}</td>--}}
                                        {{--<td> {{ $jobs->rate }}</td>--}}

                                        {{--<td>--}}
                                            {{--<div class="btn-group">--}}
                                                {{--<button class="btn btn-xs green dropdown-toggle" type="button"--}}
                                                        {{--data-toggle="dropdown" aria-expanded="false"> Actions--}}
                                                    {{--<i class="fa fa-angle-down"></i>--}}
                                                {{--</button>--}}
                                                {{--<ul class="dropdown-menu" role="menu">--}}
                                                    {{--<li>--}}
                                                        {{--<a href="">--}}
                                                            {{--<i class="fa fa-trash"></i> Delete</a>--}}
                                                    {{--</li>--}}
                                                    {{--<li>--}}
                                                        {{--<a href="">--}}
                                                            {{--<i class="fa fa-edit"></i> Edit </a>--}}
                                                    {{--</li>--}}
                                                    {{--<li>--}}
                                                        {{--<a href="">--}}
                                                            {{--<i class="fa fa-eye"></i> View </a>--}}
                                                    {{--</li>--}}
                                                    {{--<li>--}}
                                                        {{--<a href="">--}}
                                                            {{--<i class="fa fa-check-square-o"></i> Approve</a>--}}
                                                    {{--</li>--}}
                                                    {{--<li>--}}
                                                        {{--<a href="">--}}
                                                            {{--<i class="fa fa-close"></i> Reject--}}
                                                        {{--</a>--}}
                                                    {{--</li>--}}
                                                {{--</ul>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection