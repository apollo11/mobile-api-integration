@extends('layouts.app')

@section('content')
    @foreach($employers as $value)
        <form id="approve-{{ $value->id }}" action="{{ route('employer.multiple',['id' => $value->id, 'param' => 'Approve' ]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Approve">
        </form>
        <form id="reject-{{ $value->id }}" action="{{ route('employer.multiple',['id' => $value->id, 'param' => 'Reject' ]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Reject">
        </form>
        <form id="destroy-{{ $value->id }}" action="{{ route('employer.multiple',['id' => $value->id,'param' => 'Delete']) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Delete">
        </form>
    @endforeach

    <div class="page-content-wrapper employee-list">
        <div class="page-content">
            <form action="{{ route('employer.multiple')  }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">Employers</span>
                                </div>
                                {{ csrf_field() }}
                                <div class="actions">
                                    <input class="btn sbold green" name="multiple" value="Approve" type="submit"/>
                                    <input class="btn sbold green" name="multiple" value="Reject" type="submit"/>
                                    <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
                                    <a href="{{ route('employer.create') }}" id="sample_editable_1_new"
                                       class="btn sbold green"> Add New
                                        <i class="fa fa-plus"></i>
                                    </a>

                                </div>
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
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <td>Industry</td>
                                        <th>Average Hourly Rate</th>
                                        <th>Location</th>
                                        <th>Service Required </th>
                                        <th> Number of Job Posting</th>
                                        <th> Number of Candidates</th>
                                        <th> Business Manager</th>
                                        <th> Status</th>
                                        <th> Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employers as $user)

                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" name="multicheck[]" class="checkboxes"
                                                           value="{{ $user->id }}"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->company_name }}</td>
                                            <td>{{ $user->industry }}</td>
                                            <td>{{ '$'.$user->rate.'/hr' }}</td>
                                            <td>{{ '10 Bayfron avenue, 018956' }}</td>
                                            <td>{{ 'Customer Service...' }}</td>
                                            <td>{{ '34' }}</td>
                                            <td>{{ '28' }}</td>
                                            <td> {{ $user->business_manager }}</td>
                                            @if($user->status == 0 )
                                                <td><span class="label label-sm label-warning"> Pending </span></td>
                                            @elseif($user->status == 1)
                                                <td><span class="label label-sm label-success"> Approve </span></td>
                                            @elseif($user->status == 2)
                                                <td><span class="label label-sm label-warning"> Upload </span></td>
                                            @else
                                                <td><span class="label label-sm label-danger"> Reject </span></td>
                                            @endif
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{ route('job.multiple',['id' => $user->id, 'param' => 'Approve' ]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'destroy-'.$user->id }}').submit();">
                                                                <i class="fa fa-trash"></i> Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employer.details',['id' => $user->id])  }}">
                                                                <i class="fa fa-eye"></i> View </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.multiple',['id' => $user->id, 'param' => 'Approve' ])  }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'approve-'.$user->id }}').submit();">
                                                                <i class="fa fa-check-square-o"></i> Approve</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.multiple',['id' => $user->id, 'param' => 'Approve' ]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'reject-'.$user->id }}').submit();">
                                                                <i class="fa fa-close"></i> Reject
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
