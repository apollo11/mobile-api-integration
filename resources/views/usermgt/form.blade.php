@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('employee.lists')  }}">User Management</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Add New User</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Add User</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>

                                <script type="text/javascript">
                                    setTimeout(function(){  $('.alert-success').hide().remove(); }, 3000);
                                </script>
                            @endif

                            <form class="form-horizontal" method="POST" role="form"
                                  action="{{ route('mgt.store') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <input type="hidden" name="platform" value="web"/>

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
                                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Role</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="role">
                                                <option value="">--select none-- </option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="business_manager" {{ old('role') == 'business_manager' ? 'selected' : '' }}>Business Manager</option>
                                            </select>

                                            @if ($errors->has('role'))
                                                <span class="help-block">
                                        {{ $errors->first('role') }}
                                       </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('employer') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Employer</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="employer">
                                                <option value="">--select none-- </option>
                                                <option value="all" {{ old('employer') == 'all' ? 'selected' : '' }}>All</option>
                                                @foreach($employer as $key )
                                                    @if(!empty($key))
                                                        <option value="{{ $key }}" {{ old('employer') == $key ? 'selected' : '' }}>{{ $key }}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            @if ($errors->has('employer'))
                                                <span class="help-block">
                                            {{ $errors->first('employer') }}
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
                                                {{ $errors->first('password') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h4 class="col-md-3 control-label"> Permission </h4>
                                </div>
                                <div class="form-group {{ $errors->has('dashboard') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Dashboard</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="dashboard[]" value="{{ $key }}" {{ (is_array(old('dashboard')) && in_array($key, old('dashboard'))) ? ' checked' : '' }} >
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('dashboard'))
                                                <span class="help-block">
                                            {{ $errors->first('dashboard') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('employees') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Employees</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="employees[]" value="{{ $key }}" {{ (is_array(old('employees')) && in_array($key, old('employees'))) ? ' checked' : '' }} >
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('employees'))
                                                <span class="help-block">
                                                {{ $errors->first('employees') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('employers') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Employers</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="employers[]" value="{{ $key }}" {{ (is_array(old('employers')) && in_array($key, old('employers'))) ? ' checked' : '' }} >
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('employers'))
                                                <span class="help-block">
                                                    {{ $errors->first('employers') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('payout') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Payout</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="payout[]" value="{{ $key }}" {{ (is_array(old('payout')) && in_array($key, old('payout'))) ? ' checked' : '' }} >
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('payout'))
                                                <span class="help-block">
                                                {{ $errors->first('payout') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('job') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Job Management</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="job[]" value="{{ $key }}" {{ (is_array(old('job')) && in_array($key, old('job'))) ? ' checked' : '' }} >
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('job'))
                                                <span class="help-block">
                                            {{ $errors->first('job') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('reports') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Reports</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                            <label class="mt-checkbox">
                                                <input type="checkbox" name="reports[]" value="{{ $key }}" {{ (is_array(old('reports')) && in_array($key, old('reports'))) ? ' checked' : '' }} >
                                                {{ ucfirst($key) }}
                                                <span></span>
                                            </label>
                                            @endforeach
                                            @if ($errors->has('reports'))
                                                <span class="help-block">
                                                {{ $errors->first('reports') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('push') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Push Notification</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="push[]" value="{{ $key }}" {{ (is_array(old('push')) && in_array($key, old('push'))) ? ' checked' : '' }} >
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('push'))
                                            <span class="help-block">
                                                {{ $errors->first('push') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('recipient') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Recipient Group</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="recipient[]" value="{{ $key }}" {{ (is_array(old('recipient')) && in_array($key, old('recipient'))) ? ' checked' : '' }} >
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('recipient'))
                                                <span class="help-block">
                                                {{ $errors->first('recipient') }}
                                           </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('settings') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Settings</label>
                                    <div class="col-md-7">
                                        <div class="mt-checkbox-inline">
                                            @foreach($permissionValue as $key)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="settings[]" value="{{ $key }}" {{ (is_array(old('settings')) && in_array($key, old('settings'))) ? ' checked' : '' }} />
                                                    {{ ucfirst($key) }}
                                                    <span></span>
                                                </label>
                                            @endforeach
                                            @if ($errors->has('settings'))
                                                <span class="help-block">
                                                {{ $errors->first('settings') }}
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