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
                                            <textarea class="form-control ckeditor "  name="terms_conditions" id="editor1">{{ $settings->terms_conditions }}</textarea>
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
                                            <textarea class="form-control ckeditor "  name="privacy_policy" id="editor2">{{ $settings->privacy_policy }}</textarea>
                                            @if ($errors->has('privacy_policy'))
                                                <span class="help-block">
                                                {{ $errors->first('privacy_policy') }}
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
@endsection