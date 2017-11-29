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
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Job Details</span>
                            </div>
                            <div class="actions">
                                <a class="btn sbold green" href="{{ route('job.edit',['id' => $details->id ])  }}">Update</a>

                                @if($role_id == 0)
                                    @if( ($details->status=='pending' || $details->status =='inactive') && ($details->start_date >= \Carbon\Carbon::now()) ) 
                                        <a class="btn sbold green" href="{{ route('job.multiple',['id' => $details->id, 'param' => 'Approve'])  }}"
                                           onclick="event.preventDefault(); document.getElementById('{{'approve-'.$details->id }}').submit();">
                                            Approve</a>
                                    @endif
                                    @if ($details->status=='pending' || $details->status =='active')
                                        <a class="btn sbold green" href="{{ route('job.multiple',['id' => $details->id, 'param' => 'Reject']) }}" 
                                           onclick="event.preventDefault();
                                                   document.getElementById('{{'reject-'.$details->id }}').submit();">
                                            Reject
                                        </a>
                                    @endif
                                    @if ($details->status =='active')
                                        <a class="btn sbold green" href="{{ route('job.getJobsSeekers',['id' => $details->id]) }}" class="btn">Assign Job</a>
                                    @endif
                                @endif
                                <input class="btn sbold green" name="multiple" onclick="window.print()" value="Print" type="submit"/>
                                <?php
                                $currenttime = new DateTime('');
                                $job_date = (new DateTime($details->start_date))->modify('-1 hour'); ?>
                                @if ($currenttime > $job_date && $details->status == 'active' )
                                    <a href="{{ route('job.location_tracking',['id' => $details->id]) }}" class="btn sbold green">
                                            <i class="fa fa-map-marker"></i> Track Location </a>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="portlet-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            <td width="40%"><strong>Job Title</strong></td>
                                                            <td>{{ $details->job_title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Job Description</strong></td>
                                                            <td>{{ $details->job_description }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Job Requirements </strong></td>
                                                            <td>{{ $details->job_requirements }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Job Function / Role</strong></td>
                                                            <td>{{ $details->role }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Job Location</strong></td>
                                                            <td>{{ $details->geolocation_address }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Start Date &amp; Time</strong></td>
                                                            <td>{{ $details->start_date  }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>End Date &amp; Time</strong></td>
                                                            <td>{{ $details->end_date }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Job Industry</strong></td>
                                                            <td>{{ $details->industry }}</td>
                                                        </tr>

                                                    </tbody>
                                                    </table><br><br>

                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            <td><strong>No. of person requested</strong></td>
                                                            <td>{{ $details->no_of_person }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td width="40%"><strong>Age Required</strong></td>
                                                            <td>
                                                                @if(count($age) > 0)
                                                                <ul class="ul-in-table">
                                                                    @foreach($age as $key)
                                                                      <li>{{ $key->name }}</li>
                                                                    @endforeach

                                                                </ul>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Gender Needed</strong></td>
                                                            <td>{{ ucfirst($details->choices) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Nationality</strong></td>
                                                            <td>{{ ucfirst($details->nationality) }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Preferred Language</strong></td>
                                                            <td>
                                                                @if(count($language) > 0)
                                                                <ul class="ul-in-table">
                                                                    @foreach($language as $key)
                                                                        <li>{{ ucfirst($key->name) }}</li>
                                                                    @endforeach
                                                                @endif
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Important Notes</strong></td>
                                                            <td>{{ $details->notes }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Status</strong></td>
                                                            @if($details->status == 'inactive')
                                                                <td><span class="label label-sm label-danger">Need to Approve</span></td>
                                                            @elseif($details->status == 'active')
                                                                <td><span class="label label-sm label-success">{{ ucfirst($details->status) }} </span></td>
                                                            @elseif($details->status == 'expired')
                                                                <td><span class="label label-sm label-danger">{{ ucfirst($details->status) }} </span></td>

                                                            @else
                                                                <td><span class="label label-sm label-warning">{{ ucfirst($details->status) }} </span></td>
                                                            @endif
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="portlet-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="2" align="left"><img src="{{ url($details->job_image_path) }}" width="50%"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%"><strong>Employer</strong></td>
                                                            <td>{{ $details->company_name }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Business Manager</strong></td>
                                                            <td>{{ $details->job_manager }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Contact Person</strong></td>
                                                            <td>{{ $details->contact_person }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Contact No.</strong></td>
                                                            <td>{{ $details->contact_no }}</td>
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="update_schedule_status"></div>
                    <div class="portlet light bordered related-jobs">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Related Candidates Applied</span>
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
                                    <button type="button" class="btn btn-info" onclick="filter($('#min').val(), $('#max').val())">Apply</button>
                                </div>
                            </div>
                            

                            
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
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Nationality</th>
                                    <th>Religion</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Hourly Rate</th>
                                    <th> Hourly Job Rate</th>
                                    <th>Schedule Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($related) > 0)
                                    @foreach($related as $value)
                                    <?php //print_r($value);?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->nric_no }}</td>
                                        <td>{{ $value->gender }}</td>
                                        <td>{{ $value->birthdate }}</td>
                                        <td>{{ $value->nationality }}</td>
                                        <td>{{ $value->religion }}</td>
                                        <td>{{ $value->mobile_no }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->rate }}</td>
                                        <td>{{ $value->job_rate }}</td>
                                        <td>{{ jobschedule_status_display($value->schedule_status) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    @if($value->schedule_status=='pending' || $value->schedule_status=='reject_request')
                                                        <li>
                                                            <a href="{{ route('job.update_schedule') }}" class="update-schedule" data-id="{{$value->schedule_id}}" data-status="accept">
                                                            <i class="fa fa-check"></i> Accept Request</a>
                                                        </li>
                                                    @endif

                                                    @if($value->schedule_status=='pending' || $value->schedule_status=='accepted')
                                                        <li>
                                                            <a href="{{ route('job.update_schedule') }}" class="update-schedule" data-id="{{$value->schedule_id}}" data-status="reject_request">
                                                            <i class="fa fa-times"></i> Reject Request</a>
                                                        </li>
                                                    @endif

                                                    @if($value->schedule_status=='pending' || $value->schedule_status=='rejected_request' || $value->schedule_status=='accepted')
                                                        <li>
                                                            <a href="{{ route('job.update_schedule') }}" class="update-schedule" data-id="{{$value->schedule_id}}" data-status="cancel">
                                                            <i class="fa fa-times"></i> Cancel Request</a>
                                                        </li>
                                                    @endif

                                                    @if($value->schedule_status=='completed')
                                                        <li>
                                                            <a href="{{ route('job.update_schedule') }}" class="update-schedule" data-id="{{$value->schedule_id}}" data-status="approve">
                                                            <i class="fa fa-check"></i> Approve</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('job.update_schedule') }}" class="update-schedule" data-id="{{$value->schedule_id}}" data-status="reject">
                                                            <i class="fa fa-times"></i> Reject</a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="{{ route('employee.details',['id' => $value->userid ])  }}">
                                                            <i class="fa fa-eye"></i> View </a>
                                                    </li>
                                                    @if($value->schedule_status == 'completed')
                                                    <li>
                                                        <a data-toggle="modal" href="#rate_user" class="rate-user-btn"  data-rate-id="{{ $value->schedule_id }}" data-user-id="{{ $value->user_id }}">
                                                            <i class="fa fa-star"></i> Rate </a>
                                                    </li>
                                                    @endif
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

    @include('employee.rate_job')
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

        localStorage.setItem('viewtype', 'job-details');

        $('#employee-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { "extend": 'excel', "text":'Export',"className": 'btn sbold red' }
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

        $('.update-schedule').click(function(e){
            var id = $(this).data('id');
            var status = $(this).data('status');
            var url = $(this).attr('href');

            $.ajax({
                  url: url,
                  method: 'POST',
                  dataType: 'json',
                  data : {
                    'id' : id,
                    'status' : status,
                    "_token": "{{ csrf_token() }}",
                  },
                  success: function(data){
                    var detail = data.data;
                    if(data.success==true){
                        /*$('#update_schedule_status').html('').removeClass('alert alert-danger');
                        $('#update_schedule_status').html(detail.msg).addClass('alert alert-success');
                        setTimeout(function(){
                            window.location.reload(true);
                        },3000);*/
                        window.location.reload(true);
                    }else{
                        $('#update_schedule_status').html('').removeClass('alert-success');
                        $('#update_schedule_status').addClass('alert alert-danger').html(detail.error);
                    }
                  }
            });
            e.preventDefault();
            return false;
        });
    });
</script>
@stop