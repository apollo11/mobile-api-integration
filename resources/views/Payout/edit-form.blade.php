@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('payout.lists')  }}">Payout Lists</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Update Payout Job</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Update Payout</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('payout.update',['id' => $details->schedule_id ]) }}">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="form-group{{ $errors->has('working_hours') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Total Job Hours<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" placeholder="Enter working hours"
                                                   value="{{ old('working_hours') }}" name="working_hours">
                                            @if ($errors->has('working_hours'))
                                                <span class="help-block">
                                                {{ $errors->first('working_hours') }}
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