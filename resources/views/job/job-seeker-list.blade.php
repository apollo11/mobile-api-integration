@extends('layouts.app')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('job.lists')  }}">Job Lists</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Jobs Seekers Assignment</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Jobs Seekers Assignment</span>
                            </div>
                        </div>

                        <div>                        
                        <div class="portlet-body form" style="width: 65%; float: left;">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('job.sendNotification'). '/' . $details->id }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <input type="hidden" name="job_id" value="{{ $details->id }}" />
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Job Name</label>
                                        <div class="col-md-9">
                                            <label class="col-md-7 control-label" style="text-align: left;">{{ $details->job_title }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Job Date</label>
                                        <div class="col-md-9">
                                            <label class="col-md-7 control-label" style="text-align: left;">{{ $details->start_date }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Job Description</label>
                                        <div class="col-md-7">
                                            <textarea disabled class="form-control" rows="5" style="text-align: left;">{{ $details->job_description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Job Location</label>
                                        <div class="col-md-7">
                                            <textarea disabled class="form-control" rows="3" style="text-align: left;">{{ $details->location }}</textarea>
                                        </div>
                                    </div>                                    

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Contact Person</label>
                                        <div class="col-md-9">
                                            <label class="col-md-9 control-label" style="width: 50%; display: inline-block; text-align: left;">{{ $details->contact_person }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Contact Number</label>
                                        <div class="col-md-7">
                                            <label class="col-md-3 control-label" style="text-align: left;">{{ $details->contact_no }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Hourly Rate</label>
                                        <div class="col-md-7">
                                            <label class="col-md-3 control-label" style="text-align: left;">${{ $details->rate }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Agent Name</label>
                                        <div class="col-md-7">
                                            <label class="col-md-3 control-label" style="text-align: left;">{{ $details->business_manager }}</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Remark</label>
                                        <div class="col-md-7">
                                            <textarea disabled class="form-control" rows="3" style="text-align: left;">{{ $details->notes }}</textarea>
                                        </div>
                                    </div>                                    

                                </div>


                            </div>

                                <div style="float: right !important; width: 35%;">
                                    <label>Employees List</label>
                                    <div>
                                        <select class="js-example-basic-multiple" name="employees-list[]" multiple="multiple" style="width: 80%;">
                                            @foreach( $employees as $emp )
                                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Assign</button>
                                            <button type="button" class="btn default">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    
@endsection