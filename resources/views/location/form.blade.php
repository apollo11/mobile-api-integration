@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('location.lists')  }}">Location</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Add Location</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Location</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('location.add') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">

                                    <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Zip Code</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Zip Code"
                                                   value="{{ old('zip_code') }}" name="zip_code">
                                            @if ($errors->has('zip_code'))
                                                <span class="help-block">
                                            {{ $errors->first('zip_code') }}
                                           </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Location</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter Location"
                                                   value="{{ old('name') }}" name="name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                {{ $errors->first('name') }}
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