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
                                            <div class="portlet-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            @if($userDetails->userName)
                                                                <td><strong>Name</strong></td>
                                                                <td> {{ $userDetails->userName }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->birthdate)
                                                                <td><strong>BirthDate</strong></td>
                                                                <td> {{ $userDetails->birthdate }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>

                                                            @if($userDetails->religion)
                                                                <td><strong>Religion</strong></td>
                                                                <td> {{ $userDetails->religion }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->nationality)
                                                                <td><strong>Nationality</strong></td>
                                                                <td> {{ ucfirst($userDetails->nationality) }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->nric_no)
                                                                <td><strong>NRIC</strong></td>
                                                                <td> {{ $userDetails->nric_no }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->gender)
                                                                <td><strong>Gender</strong></td>
                                                                <td> {{ ucfirst($userDetails->gender) }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->address)
                                                                <td><strong>Address</strong></td>
                                                                <td> {{ $userDetails->address }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->userEmail)
                                                                <td><strong>Email Address</strong></td>
                                                                <td> {{ $userDetails->userEmail }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->userMobile)
                                                                <td><strong>Phone Number</strong></td>
                                                                <td> {{ $userDetails->userMobile }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->bank_account)
                                                                <td><strong>Bank Account </strong></td>
                                                                <td> {{ $userDetails->bank_account }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Availability</strong></td>
                                                            <td> {{ 'Not yet applicable' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Job Types</strong></td>
                                                            <td> {{ 'None' }}</td>
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->school)
                                                                <td><strong>School</strong></td>
                                                                <td> {{ $userDetails->school }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->school_pass_expiry_date != '1970-01-01')
                                                                <td><strong>School Expiry Date</strong></td>
                                                                <td> {{ $userDetails->school_pass_expiry_date }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($applied)
                                                                <td><strong>No. of jobs applied </strong></td>
                                                                <td> {{ $applied  }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($completed)
                                                                <td><strong>No. of jobs completed </strong></td>
                                                                <td> {{ $completed }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->agent_name)
                                                                <td><strong>Assigned Agent Name </strong></td>
                                                                <td> {{ $userDetails->agent_name }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->emergency_name)
                                                                <td><strong>Emergency Contact Person</strong></td>
                                                                <td> {{ $userDetails->emergency_name }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->emergency_contact_no)
                                                                <td><strong>Emergency Contact No.</strong></td>
                                                                <td> {{ $userDetails->emergency_contact_no }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->emergency_relationship)
                                                                <td><strong>Emergency Relationship</strong></td>
                                                                <td> {{ $userDetails->emergency_relationship }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->contact_method)
                                                                <td><strong>Contact Method</strong></td>
                                                                <td> {{ strtoupper($userDetails->contact_method) }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->criminal_record)
                                                                <td><strong>Criminal Record</strong></td>
                                                                <td> {{ $userDetails->criminal_record }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->medication)
                                                                <td><strong>Medication</strong></td>
                                                                <td> {{ $userDetails->medication }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->signature_file_path !='none')
                                                                <td><strong>Signature</strong></td>
                                                                <td><img src="/{{ $userDetails->signature_file_path }}" with="200px"/></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                        <td><strong>Status</strong></td>
                                                        @if($userDetails->employee_status == 'pending')
                                                                <td> <span class="label label-sm label-warning">{{ ucfirst($userDetails->employee_status) }} </span></td>
                                                            @endif

                                                            @if($userDetails->employee_status == 'approved')
                                                                <td> <span class="label label-sm label-success">{{ ucfirst($userDetails->employee_status) }} </span></td>
                                                            @endif
                                                            @if($userDetails->employee_status == 'reject')
                                                                <td> <span class="label label-sm label-danger">{{ ucfirst($userDetails->employee_status) }} </span></td>
                                                            @endif
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
                                    <th> Job Title</th>
                                    <th> Job Date</th>
                                    <th>Clients Name</th>
                                    <th>Hourly Rate</th>
                                    <th>Status</th>
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
                                            <td> {{ $jobs->company_name }}</td>
                                            <td> {{ $jobs->rate }}</td>
                                            <td> @if($jobs->schedule_status == 'cancelled') <a href="{{ route('cancel.details',['userId' => $jobs->user_id, 'jobId' => $jobs->id]) }}">{{ ucfirst($jobs->schedule_status) }}</a>  @else {{ ucfirst($jobs->schedule_status) }} @endif</td>
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