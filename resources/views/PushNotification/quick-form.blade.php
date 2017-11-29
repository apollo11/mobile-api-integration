@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('pushnotification.lists')  }}">Push Notification Lists</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Notification</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Add Notification</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('pushnotification.quickNotificationadd') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">

                                    <div class="form-group{{ $errors->has('recipient_group') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Recipient</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="recipient_group">
                                                <option value="0" {{ old('recipient_group') == 0 ? "selected" : "" }}>All</option>
                                                @foreach($recipientGroup as $key => $value)
                                                    @if($loop->count > 0)
                                                        <option value="{{ $value->id }}" {{ old('recipient_group') == $value->id ? "selected" : "" }}>{{ $value->group_name }}</option>
                                                    @else
                                                        <option value=""> No Available Recipient group </option>
                                                    @endif
                                                    <input type="text" class="form-control" value="{{ $value->group_name }}" name="group_name" style="display: none;">
                                                @endforeach
                                            </select>

                                            @if ($errors->has('recipient_group'))
                                                <span class="help-block">
                                                {{ $errors->first('recipient_group') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Notification Subject <span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" value="{{ old('subject') }}" name="subject">
                                            @if ($errors->has('subject'))
                                                <span class="help-block">
                                                {{ $errors->first('subject') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('message-content') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Notification Content<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="message-content"
                                                      rows="5" placeholder="Message Content">{{ old('message-content') }}</textarea>
                                            @if ($errors->has('message-content'))
                                                <span class="help-block">
                                                {{ $errors->first('message-content') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">Submit</button>
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