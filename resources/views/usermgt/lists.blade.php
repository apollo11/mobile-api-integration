@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper employee-list">
        <div class="page-content">
            @if($errors->has('multicheck'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong> Something went wrong. Please check.
                </div>
            @endif
            <form action="{{ route('job.multiple')  }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">List of User's</span>
                                </div>
                                {{ csrf_field() }}
                                <div class="actions">
                                    <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
                                    <a href="{{ route('mgt.create') }}" id="sample_editable_1_new"
                                       class="btn sbold green"> Add New
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="employee-table">
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
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Contact number</th>
                                        <th>Permission</th>
                                        <th>Employer's Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user as $value)
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" value="{{ $value->id }}" name="multicheck[]" class="checkboxes"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td> {{ $value->role }}</td>
                                            <td> {{ $value->email }}</td>
                                            <td>{{ $value->mobile_no }}</td>
                                            <td> {{ 'Dashboard: '. $value->dashboard_permissions }} <br />
                                                {{ 'Employees : '. $value->employees_permissions }} <br />
                                                {{ 'Employers : '. $value->employers_permissions }} <br />
                                                {{ 'Payout: '. $value->payout_permissions }} <br />
                                                {{ 'Job Mgt : '. $value->job_permissions }} <br />
                                                {{ 'Reports : '. $value->reports_permissions }} <br />
                                                {{ 'Push Notification : '. $value->push_permissions }} <br />
                                                {{ 'Recipient Group : '. $value->recipient_permissions }} <br />
                                                {{ 'Settings : '. $value->settings_permissions }} <br />
                                            </td>
                                            <td> {{ $value->employer }}</td>
                                            <td>
                                              <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{ route('job.multiple',['id' =>  $value->id, 'param' =>'Delete' ]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'destroy-'.$value->id }}').submit();">
                                                                <i class="fa fa-trash"></i> Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.edit',['id' => $value->id]) }}">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.details',['id' =>  $value->id])  }}">
                                                                <i class="fa fa-eye"></i> View </a>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@include('layouts.employee-datatables-include')