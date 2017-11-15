@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Settings</span>
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

                            <form class="form-horizontal" method="POST" role="form" action="{{ route('settings.update') }}">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="form-group{{ $errors->has('terms_conditions') ? ' has-error' : '' }}">
                                        <label class="col-md-12 text-left">Terms &amp; Conditions</label>
                                        <div class="col-md-12">
                                            <textarea class="form-control ckeditor "  name="terms_conditions" id="editor1">{{ old('terms_conditions',$settings->terms_conditions) }}</textarea>
                                            @if ($errors->has('terms_conditions'))
                                                <span class="help-block">
                                                {{ $errors->first('terms_conditions') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('privacy_policy') ? ' has-error' : '' }}">
                                        <label class="col-md-12 text-left">Privacy Policy</label>
                                        <div class="col-md-12">
                                            <textarea class="form-control ckeditor "  name="privacy_policy" id="editor2">{{ old('privacy_policy',$settings->privacy_policy) }}</textarea>
                                            @if ($errors->has('privacy_policy'))
                                                <span class="help-block">
                                                {{ $errors->first('privacy_policy') }}
                                               </span>
                                            @endif
                                        </div>
                                    </div>

                                    <hr>
                                    <h4>Point System</h4>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group{{ $errors->has('point_basic') ? ' has-error' : '' }}">
                                                <label class="col-md-12">Basic points setting <span class="is-required">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Basic Point" value="{{  old('point_basic', $settings->point_basic ) }}" name="point_basic">
                                                   
                                                    @if ($errors->has('point_basic'))
                                                        <span class="help-block">
                                                        {{ $errors->first('point_basic') }}
                                                       </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('point_reject_job') ? ' has-error' : '' }}">
                                                <label class="col-md-12">Reject an assignment <span class="is-required">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Reject an assignment" value="{{  old('point_reject_job', $settings->point_reject_job ) }}" name="point_reject_job">
                                                   
                                                    @if ($errors->has('point_reject_job'))
                                                        <span class="help-block">
                                                        {{ $errors->first('point_reject_job') }}
                                                       </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('point_late_job') ? ' has-error' : '' }}">
                                                <label class="col-md-12">Late to assigned job <span class="is-required">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Late to assigned job" value="{{  old('point_late_job', $settings->point_late_job ) }}" name="point_late_job">
                                                   
                                                    @if ($errors->has('point_late_job'))
                                                        <span class="help-block">
                                                        {{ $errors->first('point_late_job') }}
                                                       </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group{{ $errors->has('point_cancel_job_w_reason') ? ' has-error' : '' }}">
                                                <label class="col-md-12">Cancel accepted job with valid reason<span class="is-required">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Cancel accepted job with valid reason" value="{{  old('point_cancel_job_w_reason', $settings->point_cancel_job_w_reason ) }}" name="point_cancel_job_w_reason">
                                                   
                                                    @if ($errors->has('point_cancel_job_w_reason'))
                                                        <span class="help-block">
                                                        {{ $errors->first('point_cancel_job_w_reason') }}
                                                       </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('point_cancel_job_wt_reason') ? ' has-error' : '' }}">
                                                <label class="col-md-12">Cancel accepted job without valid reason <span class="is-required">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Cancel accepted job without valid reason" value="{{  old('point_cancel_job_wt_reason', $settings->point_cancel_job_wt_reason ) }}" name="point_cancel_job_wt_reason">
                                                   
                                                    @if ($errors->has('point_cancel_job_wt_reason'))
                                                        <span class="help-block">
                                                        {{ $errors->first('point_cancel_job_wt_reason') }}
                                                       </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('point_dont_turnup_job') ? ' has-error' : '' }}">
                                                <label class="col-md-12">Did not turn up to assigned job <span class="is-required">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Did not turn up to assigned job" value="{{  old('point_dont_turnup_job', $settings->point_dont_turnup_job ) }}" name="point_dont_turnup_job">
                                                   
                                                    @if ($errors->has('point_dont_turnup_job'))
                                                        <span class="help-block">
                                                        {{ $errors->first('point_dont_turnup_job') }}
                                                       </span>
                                                    @endif
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('point_min') ? ' has-error' : '' }}">
                                                <label class="col-md-12">Minimum points required to not get approved from admin <span class="is-required">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Minimum points required to not get approved from admin " value="{{  old('point_min', $settings->point_min ) }}" name="point_min">
                                                   
                                                    @if ($errors->has('point_min'))
                                                        <span class="help-block">
                                                        {{ $errors->first('point_min') }}
                                                       </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-9">
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

@section('custom_page_js')
<script src="{{ asset('assets/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script>
    var custom_ckconfig = {
                toolbar: [
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','Strike', '-', 'RemoveFormat' ] },
                    { name: 'styles', items: [ 'Styles', 'Format' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
                    { name: 'links', items: [ 'Link', 'Unlink' ] },
                    { name: 'insert', items: [ 'Image', 'EmbedSemantic', 'Table' ] },
                ],
            }
            CKEDITOR.replace('editor1',custom_ckconfig);
            CKEDITOR.replace('editor2',custom_ckconfig);
</script>
@stop