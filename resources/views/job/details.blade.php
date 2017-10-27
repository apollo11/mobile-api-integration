@extends('layouts.app')
@section('content')
    @foreach($related as $value)
        <form id="destroy-{{ $value->userid }}" action="{{ route('employee.destroy-one',['id' =>$value->userid ]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" value="Delete">
        </form>
    @endforeach

    <form id="approve-{{ $details->id }}"
          action="{{ route('job.multiple',['id' => $details->id, 'param' => 'Approve']) }}"
          method="POST" style="display: none;">
        <input type="submit" value="Approve">
        {{ csrf_field() }}
    </form>
    <form id="reject-{{ $details->id }}"
          action="{{ route('job.multiple',['id' => $details->id, 'param' => 'Reject']) }}"
          method="POST" style="display: none;">
        {{ csrf_field() }}
        <input type="submit" value="Reject">
    </form>
    <div class="page-content-wrapper employee-details">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('job.lists')  }}">Jobs</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Details</span>
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
                                <span class="caption-subject bold uppercase">Job Details</span>
                            </div>
                            <div class="actions">
                                <a class="btn sbold green"
                                   href="{{ route('job.edit',['id' => $details->id ])  }}">
                                    Update</a>

                                <a class="btn sbold green"
                                   href="{{ route('job.multiple',['id' => $details->id, 'param' => 'Approve'])  }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'approve-'.$details->id }}').submit();">
                                    Approve</a>
                                <a class="btn sbold green"
                                   href="{{ route('job.multiple',['id' => $details->id, 'param' => 'Approve']) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'reject-'.$details->id }}').submit();">
                                    Reject
                                </a>
                                <a class="btn sbold green" href="#" class="btn" data-toggle="modal" data-target="#job-assigned">Assign Job</a>

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
                                                <div class="col-md-12">Job Image</div>
                                                <div class="col-md-12"><img src="/{{ $details->job_image_path }}" width="400px" height="100px"/></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">Company Name:</div>
                                                <div class="col-md-8">{{ $details->company_name }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Job Tile:</div>
                                                <div class="col-md-8">{{ $details->job_title }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Business Manager</div>
                                                <div class="col-md-8">{{ $details->business_manager }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Role</div>
                                                <div class="col-md-8">{{ $details->role }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Job Description:</div>
                                                <div class="col-md-8">{{ $details->job_description }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Job Location:</div>
                                                <div class="col-md-8">{{ $details->location }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Job Industry:</div>
                                                <div class="col-md-8">{{ $details->industry }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Contact No.:</div>
                                                <div class="col-md-8">{{ $details->contact_no }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Gender Needed:</div>
                                                <div class="col-md-8">{{ $details->choices }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Rate:</div>
                                                <div class="col-md-8">${{ $details->rate }}/hr</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Nationality:</div>
                                                <div class="col-md-8">{{ ucfirst($details->nationality) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Job Requirements</div>
                                                <div class="col-md-8">{{ $details->job_requirements }}/hr</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Notes</div>
                                                <div class="col-md-8">{{ $details->notes }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">Language</div>
                                                <div class="col-md-8">${{ $details->language }}/hr</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">Status</div>
                                                @if($details->status == 'inactive')
                                                    <div class="col-md-8"><span class="label label-sm label-danger">Need to Approve</span>
                                                    </div>

                                                @elseif($details->status == 'active')
                                                    <div class="col-md-8"><span
                                                                class="label label-sm label-success">{{ ucfirst($details->status) }} </span>
                                                    </div>
                                                @else
                                                    <div class="col-md-8"><span
                                                                class="label label-sm label-waring">{{ ucfirst($details->status) }} </span>
                                                    </div>
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
                                <span class="caption-subject bold uppercase">Related Candidates Applied</span>
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
                                    <th>Name</th>
                                    <th>NRIC</th>
                                    <th>Contact No</th>
                                    <th>Hourly Rate</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($related) > 0)
                                    @foreach($related as $value)
                                    <tr class="odd gradeX">
                                        <th>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </th>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->nric_no }}</td>
                                        <td>{{ $value->contact_no }}</td>
                                        <td>{{ $value->rate }}</td>

                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="{{ route('employee.destroy-one',['id' => $value->userid]) }}"
                                                           onclick="event.preventDefault();
                                                                   document.getElementById('{{'destroy-'.$value->userid }}').submit();">
                                                            <i class="fa fa-trash"></i> Delete</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('employee.edit',['id' => $value->userid ])  }}">
                                                            <i class="fa fa-edit"></i> Edit </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('employee.details',['id' => $value->userid ])  }}">
                                                            <i class="fa fa-eye"></i> View </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
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
    @include('job.assign-job')
@endsection