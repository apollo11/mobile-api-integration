@extends('layouts.app')

@section('content')
    @if($employer->status == 0 || $employer->status == 3)
    <form id="approve-{{ $employer->id }}"
          action="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Approve' ]) }}" method="POST"
          style="display: none;">
        {{ csrf_field() }}
        <input type="submit" name="multiple" value="Approve">
    </form>
    @endif

    @if($employer->status == 0 || $employer->status == 1 )
    <form id="reject-{{ $employer->id }}"
          action="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Reject' ]) }}" method="POST"
          style="display: none;">
        {{ csrf_field() }}
        <input type="submit" name="multiple" value="Reject">
    </form>
    @endif
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
                <div class="col-md-12">
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

                                 @if($employer->status == 0 || $employer->status == 3)
                                <a class="btn sbold green"
                                   href="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Approve' ])  }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'approve-'.$employer->id }}').submit();">
                                    Approve</a>
                                @endif

                                @if($employer->status == 0 || $employer->status == 1)
                                <a class="btn sbold green"
                                   href="{{ route('employer.multiple',['id' => $employer->id, 'param' => 'Reject' ]) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{'reject-'.$employer->id }}').submit();">
                                    Reject
                                </a>
                                @endif

                                <input class="btn sbold green" name="multiple" onclick="window.print()" value="Print"
                                       type="submit"/>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body">
                                            <div class=" col-md-6">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="2" align="center">
                                                 <?php $profileurl = $employer->profile_image_path; 
                                            if ($profileurl==null || $profileurl == ''){ $profileurl = asset('assets/images/default_user_profile_big.png');}else{ $profileurl = url( $profileurl ); } ?>
                                                            <img alt="" class="img-circle" src= "{{ $profileurl }}"" style="max-width:30%;" />
                                                        </tr>
                                                        <tr>
                                                            <td width="40%"><strong>Company Name</strong></td>
                                                            <td>{{ $employer->company_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Email Address</strong></td>
                                                            <td>{{ $employer->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Company Description </strong></td>
                                                            <td>{{ $employer->company_description }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Business Manager </strong></td>
                                                            <td>{{ $employer->business_manager_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Contact Person </strong></td>
                                                            <td>{{ $employer->contact_person }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Contact Number </strong></td>
                                                            <td>{{ $employer->contact_no }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Hourly Rate</strong></td>
                                                            <td>{{ $employer->rate }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Industry</strong></td>
                                                            <td>{{ $employer->industry_name }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table><br><br>

                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            <td width="40%"><strong>Posted Jobs</strong></td>
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
                        <div class="portlet-body employer-details-table">

                            <div>
                                <div style="width: 40%; display: inline-block;">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" id="min" placeholder="FROM">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>

                                <div style="width: 40%; display: inline-block;">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" id="max" placeholder="TO">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>

                                <div style="display: inline-block; vertical-align: top;">
                                    <button type="button" class="btn btn-info" onclick="filter()">Apply</button>
                                </div>
                            </div>


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
                                    <th>Employees Required</th>
                                    <th>Employees Applied</th>
                                    <th>Rate</th>
                                    <th>Job Date & Time</th>
                                    <th>Business Manager</th>
                                    <th>Job Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
    
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/filtering/row-based/range_dates.js"></script> -->

@endsection

@include('layouts.employee-datatables-include')