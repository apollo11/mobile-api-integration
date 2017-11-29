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
                        <span>Edit Job</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Edit Job</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('job.update',['id' => $details->id]) }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <input type="hidden" name="job_id" value="{{ $details->id }}" />
                                    <div class="form-group{{ $errors->has('job_title') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Title<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Job Title"
                                                   value="{{ old('job_title',$details->job_title) }}" name="job_title">
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
                                                      rows="3">{{ old('job_description',$details->job_description) }}</textarea>
                                            @if ($errors->has('job_description'))
                                                <span class="help-block">
                                                {{ $errors->first('job_description') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('job_requirements') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Job Requirements</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="job_requirements"
                                                      rows="3">{{ old('job_requirements',$details->job_requirements) }}</textarea>
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
                                                   value="{{ old('job_role',$details->role) }}" name="job_role">
                                            @if ($errors->has('job_role'))
                                                <span class="help-block">
                                                {{ $errors->first('job_role') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>


                                     <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Zip Code<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Postal Code"
                                                   value="{{ old('postal_code',$details->zip_code) }}" name="postal_code">
                                            <p class="help-block"> Zip Code must be 6 digits ie.(018956)</p>
                                            @if ($errors->has('postal_code'))
                                                <span class="help-block">
                                                {{ $errors->first('postal_code') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('job_location') ? ' has-error' : '' }}" style="display:none;">
                                        <label class="col-md-3 control-label">Filter by location<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="job_location">
                                              @foreach( $location as $value)
                                                    {{ $input = $value->id.'.'.$value->name }}
                                                    @if($loop->count == 0)
                                                        <option value="none">None</option>
                                                    @else
                                                        <option value="{{ $input  }}" {{ old('job_location',$details->location) == $input ? "selected" : "" }}>{{ $value->name }}</option>
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

                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Start Date and Time<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-group date form_datetime form_datetime bs-datetime" id="start-date" data-date-format="yyyy-mm-dd hh:ii">
                                                <input type="text" name="date" value="{{ old('date',$details->start_date) }}" size="16" class="form-control">
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
                                        <label class="control-label col-md-3">End Date and Time<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-group date form_datetime form_datetime bs-datetime" id="end-date">
                                                <input type="text" name="end_date" value="{{ old('end_date',$details->end_date) }}" size="16" class="form-control">
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

                                     <div class="form-group{{ $errors->has('industry') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Industry</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="industry">
                                                @foreach( $industry as $value)
                                                    {{ $input = $value->id.'.'.$value->name }}
                                                    @if($loop->count == 0)
                                                        <option value="none">None</option>
                                                    @else
                                                        <option value="{{ $input  }}" {{ old('industry', $details->industry_id) == $input ? "selected" : "" }}>{{ $value->name }}</option>
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
                                    <br><br>

                                    <div class="form-group{{ $errors->has('no_of_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">No. of person requested<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter no. of person requested"
                                                   value="{{ old('no_of_person',$details->no_of_person) }}" name="no_of_person">
                                            @if ($errors->has('no_of_person'))
                                                <span class="help-block">
                                                {{ $errors->first('no_of_person') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('age') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Age</label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                @foreach($age as $key => $value)
                                                    <label class="mt-checkbox">
                                                        <input type="checkbox" name="age[]" value="{{ $value }}" 
                                                            <?php if( in_array($value,$existing_age)){ echo 'checked = "checked"'; } ?> >
                                                        {{ $value }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                                @if ($errors->has('age'))
                                                    <span class="help-block">
                                                {{ $errors->first('age') }}
                                               </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Gender</label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" value="male" {{ old('gender',$details->choices) == 'male' ? 'checked' : '' }}>
                                                    Male
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" value="female" {{ old('gender',$details->choices) == 'female' ? 'checked' : '' }}>
                                                    Female
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" value="both" {{ old('gender',$details->choices) == 'both' ? 'checked' : '' }}>
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
                                   

                                    <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Nationality</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="nationality">
                                                <option value="">-- select one --</option>
                                                @foreach($nationality as $key => $value)
                                                    <option value="{{$value}}" {{ old('nationality',$details->nationality) == $value ? "selected" : "" }}> {{ $value  }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('nationality'))
                                                <span class="help-block">
                                                {{ $errors->first('nationality') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('preferred_language') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Preferred Language</label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                @foreach($language as $key => $value)
                                                    <label class="mt-checkbox">
                                                        <input type="checkbox" name="preferred_language[]" value="{{ $value }}" <?php if( in_array($value,$existing_lang)){ echo 'checked = "checked"'; } ?> >
                                                        {{ ucfirst($value) }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                                @if ($errors->has('preferred_language'))
                                                    <span class="help-block">
                                                {{ $errors->first('preferred_language') }}
                                               </span>
                                                @endif

                                            </div>
                                        </div>
                                    </div><br><br>

                                    <div class="form-group{{ $errors->has('job_image') ? ' has-error' : '' }}">
                                        <label for="Image Upload" class="col-md-3 control-label">Job Image @if (empty($details->job_image_path))<span class="is-required">*</span>@endif</label>
                                        <div class="col-md-9">
                                            @if (!empty($details->job_image_path))
                                            <img src="{{ url($details->job_image_path) }}" width="50%"/><br><br>
                                            @endif
                                            <input type="file" name="job_image" value="{{ old('job_image') }}">
                                            @if ($errors->has('job_image'))
                                                <span class="help-block">
                                                {{ $errors->first('job_image') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    

                                    <div class="form-group{{ $errors->has('job_employer') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Employer<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="job_employer">
                                                @foreach( $employer as $value)
                                                    {{ $input = $value->id.'.'.$value->company_name }}

                                                    <option value="{{ $input }}" {{ ( old('job_employer') == $input || $details->employer_id == $value->id ) ? "selected" : "" }}>{{ $value->company_name }}</option>
                                                @endforeach
                                            </select>
                                                

                                            @if ($errors->has('job_employer'))
                                                <span class="help-block">
                                                {{ $errors->first('job_employer') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('business_manager') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Business Manager</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="business_manager">
                                                @foreach($businessMngr as $key => $value)
                                                    {{ $input = $key.'.'.$value }}
                                                    @if($loop->count > 0)
                                                        <option value="{{ $input }}" {{ $key == old('business_manager',$details->job_manager_id) ? "selected" : "" }}>{{ $value }}</option>
                                                    @else
                                                        <option value=""> No Available Business </option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            @if ($errors->has('business_manager'))
                                                <span class="help-block">
                                                {{ $errors->first('business_manager') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact Person</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Contact Person"
                                                   value="{{ old('contact_person',$details->contact_person) }}" name="contact_person">
                                            @if ($errors->has('contact_person'))
                                                <span class="help-block">
                                               {{ $errors->first('contact_person') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact No.</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Contact No."
                                                   value="{{ old('contact_no',$details->contact_no) }}" name="contact_no">
                                            @if ($errors->has('contact_no'))
                                                <span class="help-block">
                                                {{ $errors->first('contact_no') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Important Notes</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="notes" rows="3">{{ old('notes',$details->notes) }}</textarea>
                                            @if ($errors->has('notes'))
                                                <span class="help-block">
                                                {{ $errors->first('notes') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Submit</button>
                                            <a href="{{ route('job.details',['id' => $details->id])  }}" class="btn default">Cancel</a>
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