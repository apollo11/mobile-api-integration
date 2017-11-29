<form class="form-horizontal" method="POST" role="form" action="{{ route('assign.job') }}"
      enctype="multipart/form-data">
    <input type="hidden" name="job_id" value="{{ $details->id }}">
    {{ csrf_field() }}
    <div class="modal fade bs-modal-lg" id="job-assigned" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Job Seeker Assignment</h4>
                </div>
                <div class="modal-body">
                    @if($errors->has('user_assign'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Something went wrong. Please select data before making changes.
                        </div>
                    @endif

                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">Company Name:</div>
                                    <div class="col-md-8">{{ $details->company_name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Job Title:</div>
                                    <div class="col-md-8">{{ $details->job_title }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Business Manager</div>
                                    <div class="col-md-8">{{ $details->business_manager }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Role</div>
                                    <div class="col-md-8">{{ $details->role }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Job Description:</div>
                                    <div class="col-md-8">{{ $details->job_description }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Job Location:</div>
                                    <div class="col-md-8">{{ $details->location }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Job Industry:</div>
                                    <div class="col-md-8">{{ $details->industry }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Rate:</div>
                                    <div class="col-md-8">${{ $details->rate }}/hr</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Notes</div>
                                    <div class="col-md-8">{{ $details->notes }}</div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                       id="employee-table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </th>
                                        <th> Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $list as $value )
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">

                                                    <input type="checkbox" name="user_id[]" class="checkboxes"
                                                           value="{{ $value->id }}"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{ $value->name }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn green" value="Save changes">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
