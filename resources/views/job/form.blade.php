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
                        <span>Add New Job</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Add Job</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('job.add') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">

                                    <div class="form-group{{ $errors->has('job_title') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Title</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Job Title"
                                                   value="{{ old('job_title') }}" name="job_title">
                                            @if ($errors->has('job_title'))
                                                <span class="help-block">
                                                {{ $errors->first('job_title') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_description') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Description</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="job_description" rows="3"></textarea>
                                            @if ($errors->has('job_description'))
                                                <span class="help-block">
                                                {{ $errors->first('job_description') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_role') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Function / Role</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Job Role"
                                                   value="{{ old('job_role') }}" name="job_role">
                                            @if ($errors->has('job_role'))
                                                <span class="help-block">
                                                {{ $errors->first('job_role') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Gender</label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" value="male">
                                                    Male
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" value="female">
                                                    Female
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" value="both">
                                                    both
                                                    <span></span>
                                                </label>
                                                @if ($errors->has('gender'))
                                                    <span class="help-block">
                                                {{ $errors->first('gender') }}
                                               </span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_image') ? ' has-error' : '' }}">
                                        <label for="Image Upload" class="col-md-3 control-label">Job Image</label>
                                        <div class="col-md-9">
                                            <input type="file" name="job_image" value="{{ old('job_image') }}">
                                            @if ($errors->has('job_image'))
                                                <span class="help-block">
                                                {{ $errors->first('job_image') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('no_of_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">No. of person requested</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter no. of person requested"
                                                   value="{{ old('no_of_person') }}" name="no_of_person">
                                            @if ($errors->has('job_role'))
                                                <span class="help-block">
                                                {{ $errors->first('job_role') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact Person</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Contact Person"
                                                   value="{{ old('contact_person') }}" name="contact_person">
                                            @if ($errors->has('contact_person'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('contact_person') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('business_manager') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Business Manager</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Business Manager"
                                                   value="{{ old('business_manager') }}" name="business_manager">
                                            @if ($errors->has('business_manager'))
                                                <span class="help-block">
                                                {{ $errors->first('business_manager') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_employer') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Employer</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" value="{{ old('job_employer') }}"
                                                   name="job_employer">
                                            @if ($errors->has('job_employer'))
                                                <span class="help-block">
                                                {{ $errors->first('job_employer') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('hourly_rate') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Hourly Rate</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Hourly Rate"
                                                   value="{{ old('hourly_rate') }}" name="hourly_rate">
                                            @if ($errors->has('hourly_rate'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('hourly_rate') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('preferred_language') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Preferred Language</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="preferred_language">
                                                <option value="english">English</option>
                                            </select>
                                            @if ($errors->has('preferred_language'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('preferred_language') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Job Date and Time</label>
                                        <div class="col-md-7">
                                            <div class="input-group date form_datetime form_datetime bs-datetime">
                                                <input type="text" name="date" size="16" class="form-control">
                                                <span class="input-group-addon">
                                                    <button class="btn default date-set" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                                        </span>
                                                @if ($errors->has('date'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('date') }}</strong>
                                               </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Important Notes</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="notes" rows="3"></textarea>
                                            @if ($errors->has('notes'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('notes') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_status') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Status</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="job_status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @if ($errors->has('job_status'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('job_status') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Submit</button>
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
@endsection