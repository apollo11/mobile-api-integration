    <!-- update Profile Image -->
    <div class="modal fade" id="profile-img" tabindex="-1" role="dialog" aria-hidden="true">
        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.update') }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Profile Image</h4>
                    </div>
                    <div class="modal-body">
                        <input name="profile_image" type="file" name="profile_image" />
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
        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.update') }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Front IC</h4>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="profile_front_if" />
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
        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.update') }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Back IC</h4>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="profile_back_ic" />
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
        <form class="form-horizontal" method="POST" role="form" action="{{ route('employee.update') }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Bank Statement</h4>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="profile_bank_statement" />
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
