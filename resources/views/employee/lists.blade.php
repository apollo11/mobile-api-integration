@extends('layouts.app')

@section('content')
    @for( $i = 0; $i < $count; $i++ )
        <form id="approve-{{ $employee[$i]['id'] }}" action="{{ route('employee.approve',['id' => $employee[$i]['id']]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <form id="reject-{{ $employee[$i]['id'] }}" action="{{ route('employee.reject',['id' => $employee[$i]['id']]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" value="Reject">
        </form>
        <form id="destroy-{{ $employee[$i]['id'] }}" action="{{ route('employee.destroy-one',['id' => $employee[$i]['id']]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" value="Delete">
        </form>
    @endfor

    <div class="page-content-wrapper">
        <div class="page-content">
            <form action="{{ route('employee.destroy-all')  }}" method="POST">
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

                                    @for( $i = 0; $i < $count; $i++ )

                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" name="multicheck[]" class="checkboxes"
                                                           value="{{ $employee[$i]['id'] }}"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td><a href="#"> {{ $employee[$i]['name'] }} </a></td>
                                            <td>
                                                {{ $employee[$i]['nric_no'] }}
                                            </td>
                                            <td>{{ $employee[$i]['mobile_no'] }}</td>
                                            <td> {{ $employee[$i]['gender'] }}</td>
                                            <td> {{ $employee[$i]['birthdate']  }}</td>
                                            <td>{{ 'Not yet available' }}</td>
                                            <td>{{ $employee[$i]['business_manager'] }}</td>
                                            <td>  {{ $employee[$i]['applied']  }}</td>
                                            <td>{{ $employee[$i]['completed'] }} </td>

                                            @if($employee[$i]['employee_status'] == 'pending')
                                                <td><span class="label label-sm label-warning"> Pending </span></td>

                                            @elseif($employee[$i]['employee_status'] == 'reject')
                                                <td>
                                                    <span class="label label-sm label-danger">{{ ucfirst($employee[$i]['employee_status']) }} </span>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="label label-sm label-success">{{ ucfirst($employee[$i]['employee_status']) }} </span>
                                                </td>
                                            @endif
                                            <td class="center"> {{ $employee[$i]['joined'] }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{ route('employee.destroy-one',['id' => $employee[$i]['id']]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'destroy-'.$employee[$i]['id'] }}').submit();">
                                                                <i class="fa fa-trash"></i> Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employee.details',['id' => $employee[$i]['id']])  }}">
                                                                <i class="fa fa-eye"></i> View </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employee.approve',['id' => $employee[$i]['id']])  }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'approve-'.$employee[$i]['id'] }}').submit();">
                                                                <i class="fa fa-check-square-o"></i> Approve</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employee.reject',['id' => $employee[$i]['id']]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'reject-'.$employee[$i]['id'] }}').submit();">
                                                                <i class="fa fa-close"></i> Reject
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
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
    {{--<form id="reject" action="{{ route('employee.pending',['id' => $user->id]) }}" method="POST">--}}
        {{--{{ csrf_field() }}--}}
        {{--<button type="button">--}}
            {{--<span class="glyphicon glyphicon-search"></span> Reject--}}
        {{--</button>--}}
        {{--<input type="submit" value="Pending">--}}
    {{--</form>--}}

    {{--<a href="{{ route('employee.pending',['id' => $user->id])  }}"--}}
       {{--onclick="event.preventDefault();--}}
               {{--document.getElementById('{{'reject-'.$user->id }}').submit();">--}}
        {{--<i class="fa fa-close"></i>--}}
    {{--</a>--}}


    {{--<a href="{{ route('employee.approve',['id' => $user->id]) }}"--}}
       {{--onclick="event.preventDefault();--}}
               {{--document.getElementById('{{'approve-'.$user->id }}').submit();">--}}
        {{--<i class="fa fa-check"></i>--}}
    {{--</a>--}}

@endsection
