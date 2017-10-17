@extends('layouts.app')
@section('content')
    <form id="approve-{{ $userDetails->id }}" action="{{ route('employee.approve',['id' => $userDetails->id]) }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <form id="reject-{{ $userDetails->id }}" action="{{ route('employee.reject',['id' => $userDetails->id]) }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        <input type="submit" value="Reject">
    </form>

    <div class="page-content-wrapper">
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
                                <a class="btn sbold green" href="{{ route('employee.edit',['id' => $userDetails->id])  }}">
                                    Update</a>

                                <a class="btn sbold green" href="{{ route('employee.approve',['id' => $userDetails->id])  }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'approve-'.$userDetails->id }}').submit();">
                                    Approve</a>
                                <a class="btn sbold green" href="{{ route('employee.reject',['id' => $userDetails->id]) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'reject-'.$userDetails->id }}').submit();">
                                    Reject
                                </a>
                                <input class="btn sbold green" name="multiple" value="Print" type="submit"/>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group">
                                            <div class="col-md-4">Name</div> <div class="col-md-8"> {{ $userDetails->userName }}</div>
                                            <div class="col-md-4">Nationality</div> <div class="col-md-8"> {{ 'Not yet applicable' }}</div>
                                            <div class="col-md-4">NRIC</div> <div class="col-md-8"> {{ $userDetails->nric_no }}</div>
                                            <div class="col-md-4">Gender</div> <div class="col-md-8"> {{ !$userDetails->gender ? 'Not yet applicable' : $userDetails->gender }}</div>
                                            <div class="col-md-4">Age</div> <div class="col-md-8"> {{ 'None' }}</div>
                                            <div class="col-md-4">Address</div> <div class="col-md-8"> {{ !$userDetails->address ? 'Not yet applicable' : $userDetails->address }}</div>
                                            <div class="col-md-4">Email Address</div> <div class="col-md-8"> {{ !$userDetails->email ? $userDetails->userEmail : $userDetails->email  }}</div>
                                            <div class="col-md-4">Phone Number</div> <div class="col-md-8"> {{ $userDetails->userMobile }}</div>
                                            <div class="col-md-4">Bank Account</div> <div class="col-md-8"> {{ 'Not yet applicable' }}</div>
                                            <div class="col-md-4">Availability</div> <div class="col-md-8"> {{ 'Not yet applicable' }}</div>
                                            <div class="col-md-4">Job Types</div> <div class="col-md-8"> {{ 'None' }}</div>
                                            <div class="col-md-4">School</div> <div class="col-md-8"> {{ !$userDetails->school ? ' Not yet applicable' : $userDetails->school }}</div>
                                            <div class="col-md-4">No. of jobs applied</div> <div class="col-md-8"> {{ $applied  }}</div>
                                            <div class="col-md-4">No. of jobs completed</div> <div class="col-md-8"> {{ $completed }}</div>
                                            <div class="col-md-4">Assigned Agent Name</div> <div class="col-md-8"> {{'Not yet applicable' }}</div>
                                            <div class="col-md-4">Status</div> <div class="col-md-8"> {{ $userDetails->employee_status }}</div>
                                            <div class="col-md-12">Signature</div>
                                            <div class="col-md-12"> <img src="/{{ $userDetails->signature_file_path }}" width="" /> </div>
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