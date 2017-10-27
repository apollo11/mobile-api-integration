    <!-- update Profile Image -->
    <div class="modal fade" id="profile-img" tabindex="-1" role="dialog" aria-hidden="true">

        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.edit.img',['id' => $userDetails->id]) }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Profile Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Image</label>
                            <div class="col-md-7">
                                <input type="file" class="form-control"
                                       value="{{ old('profile_image') }}" name="profile_image">
                                @if ($errors->has('profile_image'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_image') }}
                                   </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a  href="{{ URL::previous() }}" type="button" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                        <input type="submit" class="btn green" value="Save changes">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

    <!-- update Profile Front IC -->
    <div class="modal fade" id="profile-front-ic" tabindex="-1" role="dialog" aria-hidden="true">
        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.edit.frontic',['id' => $userDetails->id]) }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Front IC</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('profile_front_ic') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Image</label>
                            <div class="col-md-7">
                                <input type="file" class="form-control"
                                       value="{{ old('profile_front_ic') }}" name="profile_front_ic">
                                @if ($errors->has('profile_front_ic'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_front_ic') }}
                                   </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a  href="{{ URL::previous() }}" type="button" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                        <input type="submit" class="btn green" value="Save changes">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

    <!-- update Profile Back Ic -->
    <div class="modal fade" id="profile-back-ic" tabindex="-1" role="dialog" aria-hidden="true">
        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.edit.backic',['id' => $userDetails->id ]) }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Back IC</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('profile_back_ic') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Image</label>
                            <div class="col-md-7">
                                <input type="file" class="form-control"
                                       value="{{ old('profile_back_ic') }}" name="profile_back_ic">
                                @if ($errors->has('profile_back_ic'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_back_ic') }}
                                   </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a  href="{{ URL::previous() }}" type="button" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                        <input type="submit" class="btn green" value="Save changes">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

    <!-- update Profile Bank Statement -->
    <div class="modal fade" id="profile-bank-statement" tabindex="-1" role="dialog" aria-hidden="true">
        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.edit.bank',['id' => $userDetails->id ]) }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Bank Statement</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('bank_statement') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Image</label>
                            <div class="col-md-7">
                                <input type="file" class="form-control"
                                       value="{{ old('bank_statement') }}" name="bank_statement">
                                @if ($errors->has('bank_statement'))
                                    <span class="help-block">
                                        {{ $errors->first('bank_statement') }}
                                   </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a  href="{{ URL::previous() }}" type="button" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                        <input type="submit" class="btn green" value="Save changes">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

