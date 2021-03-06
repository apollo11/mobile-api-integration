@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('employee.lists')  }}">Employees</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Update Employee</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase">Update Employee Information</span>
                        </div>
                    </div>
                    <div class="portlet-body form row">
                        <div class="col-md-8 row">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.update',['id' => $details->id ]) }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <input type="hidden" name="platform" value="web"/>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                   value="{{ old('name',$details->userName) }}" name="name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                {{ $errors->first('name') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Email Address<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="email" class="form-control" placeholder="Enter Email Address"
                                                   value="{{ old('email',$details->userEmail) }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                {{ $errors->first('email') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Mobile No<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Mobile No"
                                                   value="{{ old('mobile_no',$details->userMobile) }}" name="mobile_no">
                                            @if ($errors->has('mobile_no'))
                                                <span class="help-block">
                                                {{ $errors->first('mobile_no') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('nric_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">NRIC</label>
                                        <div class="col-md-7">
                                            <input disabled type="text" class="form-control" placeholder="Enter NRIC"
                                                   name="nric_no" value="{{ $details->nric_no }}"/>
                                            @if ($errors->has('nric_no'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('nric_no') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">D.O.B<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input name="birthdate" value="{{ old('birthdate',$details->birthdate) }}" class="form-control  date-picker datepicker" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">

                                            @if ($errors->has('birthdate'))
                                                <span class="help-block">
                                            {{ $errors->first('birthdate') }}
                                           </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">School</label>
                                        <div class="col-md-7">
                                            <input type="text" value="{{ old('school',$details->userSchool) }}" class="form-control" placeholder="Enter School"
                                                   name="school"/>
                                            @if ($errors->has('school'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('school') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('school_expiry_date') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">School Expiry Date</label>
                                        <div class="col-md-7">
                                             <input  value="{{ old('school_expiry_date',$details->school_pass_expiry_date) }}" name="school_expiry_date" class="form-control  date-picker datepicker" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                           
                                            @if ($errors->has('school_expiry_date'))
                                                <span class="help-block">
                                            {{ $errors->first('school_expiry_date') }}
                                           </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Nationality<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="nationality">
                                                <option value="">-- select one --</option>
                                                @foreach($nationality as $key => $value)
                                                    <option value="{{$value}}" {{old('nationality', $details->nationality) == $value ? 'selected' : '' }}> {{ $value  }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('nationality'))
                                                <span class="help-block">
                                                {{ $errors->first('nationality') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Language<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="language">
                                                @foreach($language as $key => $value)
                                                    <option value="{{$value}}" {{ old('language',$details->language) == $value ? 'selected' : '' }}> {{ ucfirst($value)   }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('language'))
                                                <span class="help-block">
                                                {{ $errors->first('language') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Religion<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter religion"
                                                   name="religion" value="{{ old('religion',$details->religion) }}"/>
                                            @if ($errors->has('religion'))
                                                <span class="help-block">
                                                    {{ $errors->first('religion') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Gender<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" id="gender" value="male" {{ old('gender',$details->gender) == 'male' ? 'checked'  : '' }}> Male
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="gender" id="gender" value="female" {{ old('gender',$details->gender) == 'female' ? 'checked' : '' }}> Female
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if ($errors->has('gender'))
                                                <span class="help-block">
                                                {{ $errors->first('gender') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Hourly Rate<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter rate"
                                                   name="rate" value="{{ old('rate',$details->rate) }}"/>
                                            @if ($errors->has('rate'))
                                                <span class="help-block">
                                                    {{ $errors->first('rate') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('points') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Points<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter points"
                                                   name="points" value="{{ old('points',$details->employee_points) }}"/>
                                            @if ($errors->has('points'))
                                                <span class="help-block">
                                                    {{ $errors->first('points') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('emergency_contact_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency contact person<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter contact person"
                                                   name="emergency_contact_person" value="{{ old('emergency_contact_person',$details->emergency_name) }}"/>
                                            @if ($errors->has('emergency_contact_person'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_contact_person') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('emergency_contact_person_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency person contact no.<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter emergency contact no."
                                                   name="emergency_contact_person_no" value="{{ old('emergency_contact_person_no',$details->emergency_contact_no) }}"/>
                                            @if ($errors->has('emergency_contact_person_no'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_contact_person_no') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('emergency_person_relationship') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency person relationship<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter emergency person relationship"
                                                   name="emergency_person_relationship" value="{{ old('emergency_person_relationship',$details->emergency_relationship ) }}"/>
                                            @if ($errors->has('emergency_person_relationship'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_person_relationship') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('emergency_person_address') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Emergency person address<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   placeholder="Enter emergency person address"
                                                   name="emergency_person_address" value="{{ old('emergency_person_address',$details->emergency_address)  }}"/>
                                            @if ($errors->has('emergency_person_address'))
                                                <span class="help-block">
                                                    {{ $errors->first('emergency_person_address') }}
                                              </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('contact_method') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact Method<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="sms" {{ old('contact_method',$details->contact_method) == 'sms' ? 'checked' : '' }}
                                                    > Sms
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="phone" {{ old('contact_method',$details->contact_method) == 'phone' ? 'checked' : '' }}

                                                    > Phone
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="email" {{ old('contact_method',$details->contact_method) == 'email' ? 'checked' : '' }}

                                                    > Email
                                                    <span></span>
                                                </label>
                                                <label class="mt-checkbox">
                                                    <input type="radio" name="contact_method" id="contact_method"
                                                           value="other" {{ old('contact_method',$details->contact_method) == 'other' ? 'checked' : '' }}
                                                    > Other
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if ($errors->has('contact_method'))
                                                <span class="help-block">
                                                {{ $errors->first('contact_method') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('criminal_record') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Criminal Record</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="criminal_record" rows="3"> {{ old('criminal_record',$details->criminal_record) }}</textarea>
                                            @if ($errors->has('criminal_record'))
                                                <span class="help-block">
                                                {{ $errors->first('criminal_record') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('medication') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Medication</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="medication" rows="3">{{ old('medication', $details->medication) }}</textarea>
                                            @if ($errors->has('medication'))
                                                <span class="help-block">
                                                {{ $errors->first('medication') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Address<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="address" rows="3"> {{ old('address',$details->address ) }}</textarea>
                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                                {{ $errors->first('address') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('employee_status') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Status<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="employee_status">
                                                @foreach($employee_status as $key => $value)
                                                    <option value="{{$value}}" {{old('employee_status', $details->employee_status) == $value ? 'selected' : '' }}> {{ $value  }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('employee_status'))
                                                <span class="help-block">
                                                {{ $errors->first('employee_status') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('business_manager') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Business Manager</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="business_manager">
                                                @foreach($businessMngr as $key => $value)
                                                    @if($loop->count > 0)
                                                        <option value="{{ $key }}" {{ $key == old('business_manager',$details->agent_name) ? "selected" : "" }}>{{ $value }}</option>
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
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Submit</button>
                                            <a href="{{ route('employee.details',['id' => $details->id])  }}" class="btn default">Cancel</a>
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
</div>
@endsection