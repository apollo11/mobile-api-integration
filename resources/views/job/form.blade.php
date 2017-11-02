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
                                        <label class="col-md-3 control-label">Job Title <span class="is-required">*</span></label>
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
                                        <label class="col-md-3 control-label">Job Description<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="job_description"
                                                      rows="3">{{ old('job_description') }}</textarea>
                                            @if ($errors->has('job_description'))
                                                <span class="help-block">
                                                {{ $errors->first('job_description') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_requirements') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Requirements<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="job_requirements"
                                                      rows="3">{{ old('job_requirements') }}</textarea>
                                            @if ($errors->has('job_requirements'))
                                                <span class="help-block">
                                                {{ $errors->first('job_requirements') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_role') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Function / Role<span class="is-required">*</span></label>
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

                                    <div class="form-group{{ $errors->has('age') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Age<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="age">
                                                <option value="16-20">16-20</option>
                                                <option value="21-30">21-30</option>
                                                <option value="41-50">41-50</option>
                                                <option value="50">above 50</option>
                                            </select>

                                            @if ($errors->has('age'))
                                                <span class="help-block">
                                                {{ $errors->first('age') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Gender<span class="is-required">*</span></label>
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

                                    <div class="form-group{{ $errors->has('job_location') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Location<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="job_location">
                                                @foreach( $location as $value)
                                                    @if($loop->count == 0)
                                                        <option value="none">None</option>
                                                    @else
                                                        <option value="{{ $value->id.'.'.$value->name }}">{{ $value->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            @if ($errors->has('job_location'))
                                                <span class="help-block">
                                                {{ $errors->first('job_location') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Nationality<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="nationality">
                                                <option value="">-- select one --</option>
                                                @for ($i = 0; $i < count($nationality); $i++)
                                                    <option value="{{ strtolower($nationality[$i]) }}">{{ $nationality[$i]  }}</option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('nationality'))
                                                <span class="help-block">
                                                {{ $errors->first('nationality') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_image') ? ' has-error' : '' }}">
                                        <label for="Image Upload" class="col-md-3 control-label">Job Image<span class="is-required">*</span></label>
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
                                        <label class="col-md-3 control-label">No. of person requested<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter no. of person requested"
                                                   value="{{ old('no_of_person') }}" name="no_of_person">
                                            @if ($errors->has('no_of_person'))
                                                <span class="help-block">
                                                {{ $errors->first('no_of_person') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact Person<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Contact Person"
                                                   value="{{ old('contact_person') }}" name="contact_person">
                                            @if ($errors->has('contact_person'))
                                                <span class="help-block">
                                               {{ $errors->first('contact_person') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact No.<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Contact No."
                                                   value="{{ old('contact_no') }}" name="contact_no">
                                            @if ($errors->has('contact_no'))
                                                <span class="help-block">
                                                {{ $errors->first('contact_no') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('business_manager') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Business Manager<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            @if(Auth::user()->role_id == 1)
                                            <input type="text" class="form-control" placeholder="Enter Business Manager"
                                                   value="{{ Auth::user()->business_manager }}" name="business_manager">
                                            @endif
                                             @if(Auth::user()->role_id == 0)
                                                <input type="text" class="form-control" placeholder="Enter Business Manager"
                                                       value="{{ Auth::user()->business_manager }}" name="business_manager">
                                                @endif

                                            @if ($errors->has('business_manager'))
                                                <span class="help-block">
                                                {{ $errors->first('business_manager') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_employer') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Employer<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            @if(Auth::user()->role_id == 1)
                                                <select class="form-control" name="job_employer">
                                                    <option value="">---Select One ---</option>
                                                    <option value="{{ Auth::user()->id.'.'.Auth::user()->company_name }}" >{{ Auth::user()->company_name }}</option>
                                                </select>
                                            @endif

                                            @if(Auth::user()->role_id == 0)
                                                <select class="form-control" name="job_employer">
                                                    @foreach( $employee as $value)
                                                        @if($loop->count == 0)
                                                            <option value="">None</option>
                                                        @else
                                                            <option value="{{ $value->id.'.'.$value->company_name}}">{{ $value->company_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                            @if ($errors->has('job_employer'))
                                                <span class="help-block">
                                                {{ $errors->first('job_employer') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('hourly_rate') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Hourly Rate<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Hourly Rate"
                                                   value="{{ old('hourly_rate') }}" name="hourly_rate">
                                            @if ($errors->has('hourly_rate'))
                                                <span class="help-block">
                                                {{ $errors->first('hourly_rate') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('preferred_language') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Preferred Language<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="preferred_language">
                                                <option value="english">English</option>
                                                <option value="english">Chinese</option>
                                                <option value="english">Malay</option>
                                                <option value="english">Tamil</option>
                                                <option value="english">Hindi</option>
                                            </select>
                                            @if ($errors->has('preferred_language'))
                                                <span class="help-block">
                                                {{ $errors->first('preferred_language') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Start Job Date and Time<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-group date form_datetime form_datetime bs-datetime" id="start-date">
                                                <input type="text" name="date" size="16" class="form-control">
                                                <span class="input-group-addon">
                                                    <button class="btn default date-set" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                                @if ($errors->has('date'))
                                                    <span class="help-block">
                                                {{ $errors->first('date') }}
                                               </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Job End Date and Time<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-group date form_datetime form_datetime bs-datetime" id="end-date">
                                                <input type="text" name="end_date" size="16" class="form-control">
                                                <span class="input-group-addon">
                                                    <button class="btn default date-set" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                                        </span>
                                                @if ($errors->has('end_date'))
                                                    <span class="help-block">
                                                {{ $errors->first('end_date') }}
                                               </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Important Notes<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="notes" rows="3"></textarea>
                                            @if ($errors->has('notes'))
                                                <span class="help-block">
                                                {{ $errors->first('notes') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('industry') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Industry<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="industry">
                                                @foreach( $industry as $value)
                                                    @if($loop->count == 0)
                                                        <option value="none">None</option>
                                                    @else
                                                        <option value="{{ $value->id.'.'.$value->name}}">{{ $value->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('industry'))
                                                <span class="help-block">
                                                {{ $errors->first('industry') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Status<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="status">
                                                <option value="draft mode">Draft mode</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="help-block">
                                               {{ $errors->first('status') }}
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