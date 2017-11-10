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
                            <form class="form-horizontal" method="POST" role="form">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-md-12 text-left">Terms &amp; Conditions</label>
                                        <div class="col-md-12">
                                            <textarea class="form-control"  name="terms-conditions"></textarea>
                                            <input type="text" class="form-control" placeholder="Enter Industry"
                                                   value="{{ old('name') }}" name="name">
                                            @if ($errors->has('terms-conditions'))
                                                <span class="help-block">
                                                {{ $errors->first('terms-conditions') }}
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

<script>

</script>
@endsection