@extends('layouts.app')

@section('content')
    @foreach($job as $value)
        <form id="approve-{{ $value->id }}" action="{{ route('job.multiple',['id' => $value->id, 'param' => 'Approve' ]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Approve">
        </form>
        <form id="reject-{{ $value->id }}" action="{{ route('job.multiple',['id' => $value->id, 'param' => 'Reject' ]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Reject">
        </form>
        <form id="destroy-{{ $value->id }}" action="{{ route('job.multiple',['id' => $value->id,'param' => 'Delete']) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Delete">
        </form>
    @endforeach
    <form id="approve-{{ $employer->id }}"
          action="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Approve' ]) }}" method="POST"
          style="display: none;">
        {{ csrf_field() }}
        <input type="submit" name="multiple" value="Approve">
    </form>
    <form id="reject-{{ $employer->id }}"
          action="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Reject' ]) }}" method="POST"
          style="display: none;">
        {{ csrf_field() }}
        <input type="submit" name="multiple" value="Reject">
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
                <div class="col-md-8">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Employer Details</span>
                            </div>
                            <div class="actions">
                                <a class="btn sbold green"
                                   href="{{ route('employer.edit',['id' => $employer->id])  }}">
                                    Update</a>

                                <a class="btn sbold green"
                                   href="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Approve' ])  }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'approve-'.$employer->id }}').submit();">
                                    Approve</a>

                                <a class="btn sbold green"
                                   href="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Reject' ]) }}"
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
                                            <div class="portlet-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="2" align="center"><img src="/{{ $employer->profile_image_path }}" style="max-width:30%;"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Company Name</strong></td>
                                                            <td>{{ $employer->company_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Company Description </strong></td>
                                                            <td>{{ $employer->company_description }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Email</strong></td>
                                                            <td>{{ $employer->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Business Manager </strong></td>
                                                            <td>{{ $employer->business_manager }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Contact Person </strong></td>
                                                            <td>{{ $employer->contact_person }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Posted Jobs</strong></td>
                                                            <td> {{ $posting }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-4"><strong>Applied Jobs </strong></td>
                                                            <td class="col-md-8"> {{ $applied }}</td>
                                                        </tr>
                                                        <td class="col-md-4"><strong>Status</strong></td>
                                                        @if($employer->status == 0 )
                                                            <td><span class="label label-sm label-warning"> Pending </span></td>
                                                        @elseif($employer->status == 1)
                                                            <td><span class="label label-sm label-success"> Approve </span></td>
                                                        @elseif($employer->status == 2)
                                                            <td><span class="label label-sm label-warning"> Upload </span></td>
                                                        @else
                                                            <td><span class="label label-sm label-danger"> Reject </span></td>
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{--<div class="col-md-6">--}}
                                        {{--<div class="btn-group">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-md-12">--}}
                                                    {{--<img class="img-circle" src="/{{ $employer->profile_image_path }}" height="80px"/>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
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
                                    <th>Employer</th>
                                    <th>Job Name</th>
                                    <th> Employees Required</th>
                                    <th>Employees Applied</th>
                                    <th>Rate</th>
                                    <th> Job Date & Time</th>
                                    <th>Business Manager</th>
                                    <th> Job Location</th>
                                    <th> Status</th>
                                    <th> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($job) > 0)
                                    @foreach($job as $value)
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" value="{{ $value->id }}" name="multicheck[]" class="checkboxes"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><a href="{{ route('employer.details',['id' => $value->user_id ]) }}">{{ $value->company_name }} </a></td>
                                            <td>{{ $value->job_title }}</td>
                                            <td>{{ $value->no_of_person }}</td>
                                            <td><a href="#">0 </a></td>
                                            <td> {{ '$'.$value->rate.'/hr' }}</td>
                                            <td> {{ Carbon\Carbon::parse($value->start_date)->format('H:i:s d-m-Y') }}</td>
                                            <td> {{ $value->business_manager }}</td>
                                            <td>{{ $value->location }}</td>

                                            @if($value->status == 'inactive')

                                                <td><span class="label label-sm label-danger"> Need to Approve </span></td>

                                            @elseif($value->status == 'active')
                                                <td>
                                                    <span class="label label-sm label-success">{{ ucfirst($value->status) }} </span>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="label label-sm label-waring">{{ ucfirst($value->status) }} </span>
                                                </td>
                                            @endif
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
                                                            <a href="">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.details',['id' =>  $value->id])  }}">
                                                                <i class="fa fa-eye"></i> View </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.multiple',['id' =>  $value->id, 'param' => 'Approve'])  }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'approve-'.$value->id }}').submit();">
                                                                <i class="fa fa-check-square-o"></i> Approve</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.multiple',['id' =>  $value->id, 'param' => 'Reject']) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'reject-'.$value->id }}').submit();">
                                                                <i class="fa fa-close"></i> Reject
                                                            </a>
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
@endsection