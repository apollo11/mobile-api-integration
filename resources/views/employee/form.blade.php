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
                        <span>Add New Employee</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Register Employee</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.signup') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <input type="hidden" name="platform" value="web" />

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                   value="{{ old('name') }}" name="name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                {{ $errors->first('name') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Email Address</label>
                                        <div class="col-md-7">
                                            <input type="email" class="form-control" placeholder="Enter Email Address"
                                                   value="{{ old('email') }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                {{ $errors->first('email') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Mobile No</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Mobile No"
                                                   value="{{ old('mobile_no') }}" name="mobile_no">
                                            @if ($errors->has('mobile_no'))
                                                <span class="help-block">
                                                {{ $errors->first('mobile_no') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-7">
                                            <input type="password" class="form-control" placeholder="Enter Password"
                                                   name="password">
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('nric_no') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">NRIC</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter NRIC"
                                                   name="nric_no" />
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('nric_no') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">School</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter School"
                                                   name="school" />
                                            @if ($errors->has('school'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('school') }}</strong>
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