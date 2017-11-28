@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('employer.lists')  }}">Employers</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Add New Employer</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Register Employer</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('employer.add') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">

                                    <div class="form-group{{ $errors->has('company_logo') ? ' has-error' : '' }}">
                                        <label for="Image Upload" class="col-md-3 control-label">Company Logo<span class="is-required">*</span></label>
                                        <div class="col-md-9">
                                            <input type="file" name="company_logo" value="{{ old('company_logo') }}">
                                            @if ($errors->has('company_logo'))
                                                <span class="help-block">
                                                {{ $errors->first('company_logo') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Company Name<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Company Name" value="{{ old('company_name') }}" name="company_name">
                                            @if ($errors->has('company_name'))
                                                <span class="help-block">
                                                {{ $errors->first('company_name') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Email Address<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="email" class="form-control" placeholder="Enter Email Address" value="{{ old('email') }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                {{ $errors->first('email') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Company Description</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="company_description" rows="3"> {{ old('company_description') }}</textarea>
                                        </div>
                                    </div>

                                    {{--<div class="form-group{{ $errors->has('business_manager') ? ' has-error' : '' }}">--}}
                                        {{--<label class="col-md-3 control-label">Business Manager<span class="is-required">*</span></label>--}}
                                        {{--<div class="col-md-7">--}}
                                            {{--<input type="text" class="form-control" placeholder="Enter Business Manager" value="{{ old('business_manager') }}" name="business_manager">--}}
                                            {{--@if ($errors->has('business_manager'))--}}
                                                {{--<span class="help-block">--}}
                                                {{--{{ $errors->first('business_manager') }}--}}
                                               {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group{{ $errors->has('business_manager') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Business Manager<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="business_manager">
                                                @foreach($businessMngr as $key => $value)
                                                    @if($loop->count > 0)
                                                        <option value="{{ $key }}" {{ old('business_manager') == $key ? "selected" : "" }}>{{ $value }}</option>
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

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Password<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                {{ $errors->first('password') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact Person<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Contact Person" value="{{ old('contact_person') }}" name="contact_person">
                                            @if ($errors->has('contact_person'))
                                                <span class="help-block">
                                                {{ $errors->first('contact_person') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Contact Number<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Contact No" value="{{ old('contact_no') }}" name="contact_no">
                                            @if ($errors->has('contact_no'))
                                                <span class="help-block">
                                                {{ $errors->first('contact_no') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('hourly_rate') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Hourly Rate<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Hourly Rate" value="{{ old('hourly_rate') }}" name="hourly_rate">
                                            @if ($errors->has('hourly_rate'))
                                                <span class="help-block">
                                                {{ $errors->first('hourly_rate') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('industry') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Industry</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="industry">
                                                @foreach( $industry as $value)
                                                    @if($loop->count == 0)
                                                         <option value="none">None</option>
                                                    @else
                                                        <option value="{{ $value->id }}" {{ old('industry') == $value->id ? "selected" : "" }}>{{ $value->name }}</option>
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
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Submit</button>
                                            <a href="{{ URL::previous() }}" class="btn default">Cancel</a>
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