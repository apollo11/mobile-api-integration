@extends('layouts.app')
@section('content')
    @foreach($jobInfo as $jobs)
        <form id="destroy-{{ $jobs->jobid }}" action="{{ route('job.multiple',['id' => $jobs->jobid,'param' => 'Delete']) }}"
              method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" name="multiple" value="Delete">
        </form>
    @endforeach

    <form id="approve-{{ $userDetails->id }}" action="{{ route('employee.approve',['id' => $userDetails->id]) }}"
          method="POST" style="display: none;">
        {{ csrf_field() }}
        <input type="submit" value="Approve">
    </form>
    <form id="reject-{{ $userDetails->id }}" action="{{ route('employee.reject',['id' => $userDetails->id]) }}"
          method="POST" style="display: none;">
        {{ csrf_field() }}
        <input type="submit" value="Reject">
    </form>

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
                                   href="{{ route('employee.edit',['id' => $userDetails->id])  }}">
                                    Update</a>

                                <a class="btn sbold green"
                                   href="{{ route('employee.approve',['id' => $userDetails->id])  }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'approve-'.$userDetails->id }}').submit();">
                                    Approve</a>
                                <a class="btn sbold green"
                                   href="{{ route('employee.reject',['id' => $userDetails->id]) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'reject-'.$userDetails->id }}').submit();">
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
                                            <div class="col-md-8"> {{ $userDetails->userName }}</div>
                                            <div class="col-md-4">Nationality</div>
                                            <div class="col-md-8"> {{ 'Not yet applicable' }}</div>
                                            <div class="col-md-4">NRIC</div>
                                            <div class="col-md-8"> {{ $userDetails->nric_no }}</div>
                                            <div class="col-md-4">Gender</div>
                                            <div class="col-md-8"> {{ !$userDetails->gender ? 'Not yet applicable' : $userDetails->gender }}</div>
                                            <div class="col-md-4">Age</div>
                                            <div class="col-md-8"> {{ 'None' }}</div>
                                            <div class="col-md-4">Address</div>
                                            <div class="col-md-8"> {{ !$userDetails->address ? 'Not yet applicable' : $userDetails->address }}</div>
                                            <div class="col-md-4">Email Address</div>
                                            <div class="col-md-8"> {{ !$userDetails->email ? $userDetails->userEmail : $userDetails->email  }}</div>
                                            <div class="col-md-4">Phone Number</div>
                                            <div class="col-md-8"> {{ $userDetails->userMobile }}</div>
                                            <div class="col-md-4">Bank Account</div>
                                            <div class="col-md-8"> {{ 'Not yet applicable' }}</div>
                                            <div class="col-md-4">Availability</div>
                                            <div class="col-md-8"> {{ 'Not yet applicable' }}</div>
                                            <div class="col-md-4">Job Types</div>
                                            <div class="col-md-8"> {{ 'None' }}</div>
                                            <div class="col-md-4">School</div>
                                            <div class="col-md-8"> {{ !$userDetails->school ? ' Not yet applicable' : $userDetails->school }}</div>
                                            <div class="col-md-4">No. of jobs applied</div>
                                            <div class="col-md-8"> {{ $applied  }}</div>
                                            <div class="col-md-4">No. of jobs completed</div>
                                            <div class="col-md-8"> {{ $completed }}</div>
                                            <div class="col-md-4">Assigned Agent Name</div>
                                            <div class="col-md-8"> {{'Not yet applicable' }}</div>
                                            <div class="col-md-4">Status</div>
                                            <div class="col-md-8"> {{ $userDetails->employee_status }}</div>
                                            <div class="col-md-12">Signature</div>
                                            <div class="col-md-12"><img src="/{{ $userDetails->signature_file_path }}"
                                                                        width=""/></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
                <div class="col-md-6">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="portlet-body">
                                    <div class="mt-element-overlay">
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-4">
                                                <div class="mt-overlay-1 mt-scroll-right">

                                                    @if(!empty($userDetails->profile_photo))
                                                        <img class="img-circle" src="/{{ $userDetails->profile_photo}}" />
                                                    @else
                                                        <img class="img-circle" src="http://via.placeholder.com/300x300" />
                                                    @endif
                                                    <div class="mt-overlay">
                                                        <ul class="mt-info">
                                                            <li>
                                                                <div class="btn sbold red" data-toggle="modal" data-target="#profile-img">
                                                                   Update Profile Image
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                    <h3><a href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-img">Update Profile Image</a></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-4">
                                                <div class="mt-overlay-1 mt-scroll-right">
                                                    @if(!empty($userDetails->front_ic_path))
                                                        <img src="/{{ $userDetails->front_ic_path }}" />
                                                    @else
                                                        <img src="http://via.placeholder.com/500x300" />
                                                    @endif
                                                    <div class="mt-overlay">
                                                        <ul class="mt-info">
                                                            <li>
                                                                <div class="btn sbold red" data-toggle="modal" data-target="#profile-front-ic">
                                                                    Update Front IC
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h3><a href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-front-ic">Update Front IC</a></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-4">
                                                <div class="mt-overlay-1 mt-scroll-right">
                                                    @if(!empty($userDetails->back_ic_path))
                                                        <img src="/{{ $userDetails->back_ic_path }}" />
                                                    @else
                                                        <img src="http://via.placeholder.com/500x300" />
                                                    @endif
                                                    <div class="mt-overlay">
                                                        <ul class="mt-info">
                                                            <li>
                                                                <div class="btn sbold red" data-toggle="modal" data-target="#profile-back-ic">
                                                                    Update Back IC
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h3><a href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-back-ic">Update Back IC</a></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-4">
                                                <div class="mt-overlay-1 mt-scroll-right">
                                                    @if(!empty($userDetails->bank_statement))
                                                        <img src="/{{ $userDetails->bank_statement }}" />
                                                    @else
                                                        <img src="http://via.placeholder.com/500x300" />
                                                    @endif
                                                    <div class="mt-overlay">
                                                        <ul class="mt-info">
                                                            <li>
                                                                <div class="btn sbold red" data-toggle="modal" data-target="#profile-bank-statement">
                                                                    Update Bank Statement
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h3><a href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-bank-statement">Update Bank Statement</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="row">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="btn-group">--}}
                                            {{--<div class="col-md-12"><a href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-front-ic">Update IC (Front)</a></div>--}}
                                            {{--<div class="col-md-12"><a href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-back-ic">Update IC (back)</a></div>--}}
                                            {{--<div class="col-md-12"><a href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-bank-statement">Update Bank Statement (back)</a></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
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
                                @if(count($jobInfo) > 0)
                                    @foreach($jobInfo as $jobs)
                                        @if(!empty($jobs->job_title))
                                        <tr class="odd gradeX">
                                            <th>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" class="group-checkable"
                                                           data-set="#employee-table .checkboxes"/>
                                                    <span></span>
                                                </label>
                                            </th>
                                            <td>{{ $jobs->job_title }}</td>
                                            <td>{{ $jobs->start_date }}</td>
                                            <td> {{ $jobs->schedule_status }}</td>
                                            <td> {{ $jobs->company_name }}</td>
                                            <td> {{ $jobs->rate }}</td>

                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{ route('job.multiple',['id' =>  $jobs->jobid, 'param' =>'Delete' ]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'destroy-'.$jobs->jobid }}').submit();">
                                                                <i class="fa fa-trash"></i> Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.edit',['id' => $jobs->jobid ]) }}">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.details',['id' =>  $jobs->jobid ])  }}">
                                                                <i class="fa fa-eye"></i> View </a>
                                                        </li>                                                </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('employee.edit-profile')


@endsection