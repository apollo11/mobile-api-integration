@extends('layouts.app')

@section('content')

    <!-- set up the modal to start hidden and fade in and out -->
    {{--<div id="myModal" class="modal fade">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<!-- dialog body -->--}}
                {{--<div class="modal-body">--}}
                    {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    {{--Hello world!--}}
                {{--</div>--}}
                {{--<!-- dialog buttons -->--}}
                {{--<div class="modal-footer"><button type="button" data-dismiss="modal" class="btn btn-primary">OK</button></div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="page-content-wrapper">
        <div class="page-content">
            <form action="{{ route('employee.destroy')  }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">Employees</span>
                                </div>

                                {{ csrf_field() }}
                                {{--<input type="checkbox" name="test[]" class="checkboxes" value="1"/>--}}
                                {{--<input type="checkbox" name="test[]" class="checkboxes" value="1"/>--}}

                                {{--<button type="submit" name="submitButton" form="ApproveReject" value="Submit">Submit</button>--}}
                                <div class="actions">
                                    <input class="btn sbold green" name="multiple" value="Approve" type="submit"/>
                                    <input class="btn sbold green" name="multiple" value="Reject" type="submit"/>
                                    <a href="{{ route('employee.create') }}" id="sample_editable_1_new"
                                       class="btn sbold green"> Add New
                                        <i class="fa fa-plus"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                        <th> Name</th>
                                        <th> NRIC</th>
                                        <th>Contact No.</th>
                                        <th> Gender</th>
                                        <th> DOB</th>
                                        <th>Ratings</th>
                                        <th> Agent Name</th>
                                        <th>Jobs applied</th>
                                        <th>Jobs completed</th>
                                        <th> Status</th>
                                        <th> Joined</th>
                                        <th> Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employees as $user)
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" name="multicheck[]" class="checkboxes"
                                                           value="{{ $user->id }}"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td><a href="#"> {{ $user->name }} </a></td>
                                            <td>
                                                {{ $user->nric_no }}
                                            </td>
                                            <td>{{ $user->mobile_no }}</td>
                                            <td> Not Available</td>
                                            <td> Not Available</td>
                                            <td> Not Yet Available</td>
                                            <td>{{ $user->business_manager }}</td>
                                            <td>{{ 'None' }}</td>
                                            <td>{{ 'None' }}</td>
                                            @if($user->employee_status == 'pending')
                                                <td><span class="label label-sm label-warning"> Pending </span></td>

                                            @else
                                                <td>
                                                    <span class="label label-sm label-success">{{ $user->employee_status }} </span>
                                                </td>

                                            @endif
                                            <td class="center"> {{ $user->joined }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-trash"></i> Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-eye"></i> View </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-check-square-o"></i> Approve</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
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
