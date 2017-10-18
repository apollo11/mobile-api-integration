@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper employee-list">
        <div class="page-content">
            <form action="{{ route('employee.destroy-all')  }}" method="POST">
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
                                    <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
                                    <a href="{{ route('employee.create') }}" id="sample_editable_1_new"
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
                                        <th>Checkbox</th>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <td>Industry</td>
                                        <th>Average Hourly Rate</th>
                                        <th>Location</th>
                                        <th>Service Required </th>
                                        <th> Number of Job Posting</th>
                                        <th> Number of Candidates</th>
                                        <th> Business Manager</th>
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
                                                <td><span class="label label-sm label-warning"> Pending </span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{ route('employee.destroy-one',['id' => $user->id]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'destroy-'.$user->id }}').submit();">
                                                                <i class="fa fa-trash"></i> Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employee.details',['id' => $user->id])  }}">
                                                                <i class="fa fa-eye"></i> View </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employee.approve',['id' => $user->id])  }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'approve-'.$user->id }}').submit();">
                                                                <i class="fa fa-check-square-o"></i> Approve</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('employee.reject',['id' => $user->id]) }}"
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
