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
                                    <span class="caption-subject bold uppercase">list of Jobs</span>
                                </div>
                                {{ csrf_field() }}
                                <div class="actions">
                                    @if ($role_id == 0)
                                    <input class="btn sbold green" name="multiple" value="Approve" type="submit"/>
                                    <input class="btn sbold green" name="multiple" value="Reject" type="submit"/>
                                    @endif
                                    <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
                                    <a href="{{ route('job.create') }}" id="sample_editable_1_new"
                                       class="btn sbold green"> Add New
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body job-lists-table">

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
                                        @if ($role_id == 0)
                                        <th>Employer</th>
                                        @endif
                                        <th>Job Name</th>
                                        <th>Employees Required</th>
                                        <th>Employees Applied</th>
                                        <th>Rate</th>
                                        <th>Job Date &amp; Time</th>
                                        <th>Business Manager</th>
                                        <th>Job Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $currenttime = new DateTime('');?>
                                    @foreach($job as $value)
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" value="{{ $value->id }}" name="multicheck[]" class="checkboxes"/>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                         @if ($role_id == 0)
                                        <td><a href="{{ route('employer.details',['id' => $value->user_id ]) }}">{{ $value->company_name }} </a></td>
                                        @endif
                                        <td> <a href="{{ route('job.details',['id' =>  $value->id])  }}"> {{ $value->job_title }} </a></td>
                                        <td>{{ $value->no_of_person }}</td>
                                        <td><a href="#">0 </a></td>
                                        <td>{{ '$'.$value->rate.'/hr' }}</td>
                                        <td data-order="{{ Carbon\Carbon::parse($value->start_date)->format('d-m-Y H:i:s') }}">{{ Carbon\Carbon::parse($value->start_date)->format('d-m-Y H:i:s') }}</td>
                                        <td>{{ $value->business_manager }}</td>
                                        <td>{{ $value->geolocation_address  }}</td>

                                        @if($value->status == 'inactive')

                                            <td><span class="label label-sm label-danger">{{ ($value->start_date < \Carbon\Carbon::now()) ? 'Expired' : ucfirst($value->status) }}</span></td>

                                        @elseif($value->status == 'active')
                                            <td>
                                                <span class="label label-sm label-success">{{ ucfirst($value->status) }} </span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="label label-sm label-warning">{{ ucfirst($value->status) }} </span>
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
                                                        <a href="{{ route('job.edit',['id' => $value->id]) }}">
                                                            <i class="fa fa-edit"></i> Edit </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('job.details',['id' =>  $value->id])  }}">
                                                            <i class="fa fa-eye"></i> View </a>
                                                    </li>
                                                     @if ($role_id == 0)
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
                                                    <li>
                                                        <a href="{{ route('job.getJobsSeekers',['id' => $value->id]) }}">
                                                            <i class="fa fa-tasks"></i> Assign
                                                        </a>
                                                    </li>

                                                     <?php $job_date = (new DateTime($value->start_date))->modify('-1 hour'); ?>
                                                        @if ($currenttime > $job_date && $value->status == 'active' )
                                                            <li><a href="{{ route('job.location_tracking',['id' => $value->id]) }}">
                                                                    <i class="fa fa-map-marker"></i> Track Location </a>
                                                            </li>
                                                        @endif
                                                    @endif
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

    @if($notification_status == "success")
        <div id="notification_status_container" style="top: 50%; left: 50%; transform: translate('-50%','-50%'); position: absolute;">
            Notification has been send successfully!
        </div>
    @elseif($notification_status == "failed")
        <div id="notification_status_container" style="top: 50%; left: 50%; transform: translate('-50%','-50%'); position: absolute;">
            Notification failed!
        </div>
    @endif
    <script type="text/javascript">
        setTimeout(function(){
            $("#notification_status_container").hide()
        }, 3000)
    </script>
    
@endsection

@include('layouts.employee-datatables-include',['title'=>'List of jobs'])