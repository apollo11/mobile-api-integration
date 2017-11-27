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
                        <span>Edit Notification</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Edit Notification</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="POST" role="form" action="{{ route('pushnotification.update') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <input type="hidden" value="{{$pushNotification->id}}" name="id">
                                    <div class="form-group{{ $errors->has('receipient-group') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Receipient Group<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="receipient-group">
                                                @foreach( $groups as $group)
                                                    @if($loop->count == 0)
                                                         <option value="all"> - ALL - </option>
                                                    @else
                                                        <option value="{{ $group->id }}" {{ old('group') == $group->id ? "selected" : "" }}>{{ $group->group_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('receipient-group'))
                                                <span class="help-block">
                                               {{ $errors->first('receipient-group') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Notification Subject <span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" value="{{ $pushNotification->title }}" name="subject">
                                            @if ($errors->has('subject'))
                                                <span class="help-block">
                                                {{ $errors->first('subject') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('publish-date') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Publish Date<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-group date" data-provide="datepicker">
                                                <input type="text" class="form-control" value="{{ $pushNotification->created_at }}" name="publish-date">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                            @if ($errors->has('publish-date'))
                                                <span class="help-block">
                                                {{ $errors->first('publish-date') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('message-content') ? ' has-error' : '' }}">
                                        <label class="col-md-3 control-label">Notification Content<span class="is-required">*</span></label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="message-content"
                                                      rows="5" placeholder="Message Content">{{ $pushNotification->message }}</textarea>
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