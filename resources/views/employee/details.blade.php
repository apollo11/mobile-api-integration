@extends('layouts.app')
@section('content')
    @foreach($jobInfo as $jobs)
        <form id="destroy-{{ $jobs->jobid }}" action="{{ route('job.multiple',['id' => $jobs->jobid,'param' => 'Delete']) }}"
              method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" name="multiple" value="Delete">
        </form>

        <form id="payout-{{ $jobs->jobid }}" action="{{ route('payout.approved',['id' => $jobs->schedule_id, 'userId' => $jobs->user_id]) }}"
              method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" name="payout_submit" value="Approve">
        </form>
        <form id="reject-{{ $jobs->jobid }}" action="{{ route('payout.rejected',['id' => $jobs->schedule_id, 'userId' => $jobs->user_id]) }}"
              method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" name="reject_submit" value="Delete">
        </form>

        <form id="accept-{{ $jobs->jobid }}" action="{{ route('payout.accepted',['id' => $jobs->schedule_id, 'userId' => $jobs->user_id]) }}"
              method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" name="reject_submit" value="Delete">
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
                <div class="col-sm-6">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Employees</span>
                            </div>
                            <div class="actions">
                                @can('employee-view')
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
                                @endcan
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
                                                <div class="">
                                                    <table class="table table-hover bordered">
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
                                                            @if($userDetails->points)
                                                                <td><strong>Points</strong></td>
                                                                <td> {{ $userDetails->points }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Hourly Rate</strong></td>
                                                            <td> {{ $userDetails->rate }}</td>
                                                        </tr>
                                                        <tr>
                                                            @if($userDetails->signature_file_path !='none')
                                                                <td><strong>Signature</strong></td>
                                                                <td><img src="/{{ $userDetails->signature_file_path }}" width="200px"/></td>
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
                                                     
                                                        <tr>
                                                            <td><strong>Average Rating</strong></td>
                                                            <td>
                                                                <?php echo str_repeat('<i class="fa  fa-star"></i>',floor($userDetails->avg_rating) ); 
                                                                if($userDetails->avg_rating > floor($userDetails->avg_rating)){
                                                                    echo '<i class="fa  fa-star-half-o"></i>';
                                                                }
                                                                ?>
                                                            </td>
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
                <div class="col-sm-6">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="portlet-body">
                                    <div class="mt-element-overlay">
                                        <div class="row">
                                            <div class="col-sm-offset-2 col-sm-4">
                                                <div class="mt-overlay-1 mt-scroll-right">
                                                    @if(!empty($userDetails->profile_photo))
                                                        <img class="img-circle main-profile-img" src="{{ url($userDetails->profile_photo) }}" />
                                                    @else
                                                        <img class="img-circle main-profile-img" src="http://via.placeholder.com/300x300" />
                                                    @endif

                                                    <div class="mt-overlay">
                                                        <ul class="mt-info">
                                                            <li>
                                                                <button @cannot('employee-view') disabled @endcannot class="btn sbold red" data-toggle="modal" data-target="#profile-img">
                                                                   Update Profile Image
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                    <h3><button href="#" @cannot('employee-view') disabled @endcannot class="btn sbold green" data-toggle="modal" data-target="#profile-img">Update Profile Image</button></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-offset-2 col-sm-4">
                                                <div class="mt-overlay-1 mt-scroll-right">
                                                    @if(!empty($userDetails->front_ic_path))
                                                        <img src="/{{ $userDetails->front_ic_path }}" />
                                                    @else
                                                        <img src="http://via.placeholder.com/500x300" />
                                                    @endif
                                                    <div class="mt-overlay">
                                                        <ul class="mt-info">
                                                            <li>
                                                                <button @cannot('employee-view') disabled @endcannot class="btn sbold red" data-toggle="modal" data-target="#profile-front-ic">
                                                                    Update Front IC
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h3><button @cannot('employee-view') disabled @endcannot href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-front-ic">Update Front IC</button></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-offset-2 col-sm-4">
                                                <div class="mt-overlay-1 mt-scroll-right">
                                                    @if(!empty($userDetails->back_ic_path))
                                                        <img src="/{{ $userDetails->back_ic_path }}" />
                                                    @else
                                                        <img src="http://via.placeholder.com/500x300" />
                                                    @endif
                                                    <div class="mt-overlay">
                                                        <ul class="mt-info">
                                                            <li>
                                                                <button @cannot('employee-view') disabled @endcannot class="btn sbold red" data-toggle="modal" data-target="#profile-back-ic">
                                                                    Update Back IC
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h3><button @cannot('employee-view') disabled @endcannot href="#" class="btn sbold green" data-toggle="modal" data-target="#profile-back-ic">Update Back IC</button></h3>
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
                                    <th>Job Title</th>
                                    <th>Job Date</th>
                                    <th>Employer's Name</th>
                                    <th>Job Ratings</th>
                                    <th>Job Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($jobInfo) > 0)
                                    <?php $currenttime = new DateTime('');?>
                                    @foreach($jobInfo as $jobs)
                                        @if(!empty($jobs->job_title))
                                        <tr class="odd gradeX" id="sche-{{ $jobs->schedule_id }}">
                                            <th>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" class="group-checkable"
                                                           data-set="#employee-table .checkboxes"/>
                                                    <span></span>
                                                </label>
                                            </th>
                                            <td>{{ $jobs->job_title }}</td>
                                            <td>{{ $jobs->start_date }}</td>
                                            <td>{{ $jobs->company_name }}</td>
                                            <td>@if($jobs->rating_point!=null)
                                                    <?php echo str_repeat('<i class="fa  fa-star"></i>',$jobs->rating_point); ?>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>@if($jobs->schedule_status == 'cancelled') <a href="{{ route('cancel.details',['userId' => $jobs->user_id, 'jobId' => $jobs->id]) }}">{{ ucfirst($jobs->schedule_status) }}</a>  @else {{ ucfirst($jobs->schedule_status) }} @endif</td>
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
                                                        </li>

                                                        @if($jobs->schedule_status == 'completed')
                                                            <li>
                                                                <a data-toggle="modal" href="#rate_user" class="rate-user-btn"  data-rate-id="{{ $jobs->schedule_id }}" data-user-id="{{ $jobs->user_id }}">
                                                                    <i class="fa fa-star"></i> Rate </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('payout.approved',['id' => $jobs->schedule_id, 'userId' => $jobs->user_id])  }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'payout-'.$jobs->jobid }}').submit();">
                                                                    <i class="fa fa-check-square-o"></i> Approve</a>

                                                            </li>
                                                            <li>
                                                                <a href="{{ route('payout.rejected',['id' => $jobs->schedule_id, 'userId' => $jobs->user_id]) }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'reject-'.$jobs->jobid }}').submit();">
                                                                    <i class="fa fa-close"></i> Reject
                                                                </a>
                                                            </li>

                                                              <?php $job_date = (new DateTime($jobs->start_date))->modify('-1 hour'); ?>
                                                                @if ($currenttime > $job_date )
                                                                    <li><a href="{{ route('job.location_tracking',['id' => $jobs->id]) }}">
                                                                            <i class="fa fa-map-marker"></i> Track Location </a>
                                                                    </li>
                                                                @endif
                                                        @endif
                                                        @if($jobs->schedule_status == 'pending')
                                                            <li>
                                                                <a href="{{ route('payout.accepted',['id' => $jobs->schedule_id, 'userId' => $jobs->user_id])  }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'accept-'.$jobs->jobid }}').submit();">
                                                                    <i class="fa fa-check-square-o"></i> Approve</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('payout.rejected',['id' => $jobs->schedule_id, 'userId' => $jobs->user_id]) }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'reject-'.$jobs->jobid }}').submit();">
                                                                    <i class="fa fa-close"></i> Reject
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
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


@include('employee.rate_job')

@include('employee.edit-profile')

@endsection


@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-rating-input.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/layout/scripts/rate_job.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#employee-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { "extend": 'excel', "text":'Export',"className": 'btn sbold red', "title" : "Employee - related jobs"}
            ],
            autoFill: true,
            "scrollY":"500",
            "scrollX" : true,
            "sScrollXInner": "100%",
        });

        $('.rate-user-btn').click(function(){
            var rate_id = $(this).data('rate-id');
            var user_id = $(this).data('user-id');
            if(rate_id==null || rate_id=='' || user_id==null || user_id==''){return false;}
            
            $('.rate-user-content .rate-user-profileimg').html('').prepend($('<img>',{ class:'img-circle', src: $('.main-profile-img').attr('src') , style : 'max-width:100%' }));

            resetValues();
            
            /*get info for pop up*/
            var url = '{{url("employee/job/detail")}}/'+user_id+'/'+rate_id;
            rate_getPopUpJobDetail(url, user_id,rate_id);
            /*get info for pop up*/
        });

        $("#rating-form").submit(function(e) {
            var user_id = $('.submit-rating-btn').data('user_id');
            var rate_id = $('.submit-rating-btn').data('rate_id');

            var url = '{{url("employee/job/rate_job")}}/'+user_id+'/'+rate_id;
            rate_submitJobRating(url);
            
            e.preventDefault(); 
        });
    });
</script>
@stop
