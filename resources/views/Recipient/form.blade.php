@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('recipient.lists')  }}">Recipient Group</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create Recipient Group</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Create Recipient Group</span>
                            </div>
                        </div>
                        <div class="portlet-body form">

                            <div class="form-body">
                                <input type="hidden" name="platform" value="web"/>

                                <div class="form-group">
                                    <form class="form-horizontal" method="POST" role="form"
                                          action="{{ route('recipient.search') }}"
                                          enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <label class="col-md-2 control-label">Select</label>
                                            <div class="col-md-4">
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                                       id="select-group">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input id="group-checkable" type="checkbox"
                                                                       class="group-checkable"
                                                                       data-set="#employee-table .checkboxes"/>
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        <th>Business Manager</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($agent) > 0)
                                                        @foreach( $agent as $key)
                                                            <tr class="odd gradeX">
                                                                <td>
                                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                        <input type="checkbox" id="agent" name="agent[]"
                                                                               class="checkboxes"
                                                                               value="{{ $key->name }}"/>
                                                                        <span></span>
                                                                    </label>
                                                                </td>
                                                                <td>{{ $key->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <label class="col-md-2 control-label">Select</label>
                                            <div class="col-md-4">
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                                       id="select-group">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input id="group-checkable" type="checkbox"
                                                                       class="group-checkable"
                                                                       data-set="#employee-table .checkboxes"/>
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        <th>Employer</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($employer) > 0)
                                                        @foreach( $employer as $key )
                                                            @if(!empty($key->company_name))
                                                            <tr class="odd gradeX">
                                                                <td>
                                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                        <input type="checkbox" id="agent" name="employer[]"
                                                                               class="checkboxes"
                                                                               value="{{ $key->company_name }}"/>
                                                                        <span></span>
                                                                    </label>
                                                                </td>
                                                                <td>{{ $key->company_name }}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-offset-2 col-md-6">
                                                <input type="submit" class="btn green" value="Advance Search">
                                            </div>
                                        </div>
                                    </form>
                                    <br/>
                                    <form class="form-horizontal" method="POST" role="form"
                                          action="{{ route('recipient.store') }}"
                                          enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            @if($errors->has('employee') || $errors->has('group_name'))
                                                <div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <ul>
                                                        @if($errors->has('employee'))
                                                            <li>{{ $errors->first('employee') }}</li>
                                                        @endif
                                                        @if($errors->has('group_name'))
                                                            <li>{{ $errors->first('group_name') }}</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @endif
                                                {{--@if($errors->has('group_name'))--}}
                                                    {{--<div class="alert alert-danger alert-dismissable">--}}
                                                        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}

                                                    {{--</div>--}}
                                                {{--@endif--}}

                                            <label class="col-md-2 control-label">Group Name</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="Enter Group Name"
                                                       value="{{ old('group_name') }}" name="group_name">
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                                       id="recipient-form-list">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input id="" type="checkbox"
                                                                       class=""
                                                                       data-set="#employee-table .checkboxes"/>
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Employer</th>
                                                        <th>Business Manager</th>
                                                        <th>Job Title</th>
                                                        <th>DOB</th>
                                                        <th>Contact No.</th>
                                                        <th>NRIC</th>
                                                        <th>Availability</th>
                                                        <th>Registered Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach( $employee as $key )
                                                        <tr class="odd gradeX">
                                                            <td>
                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                    <input type="radio" id="employee" name="employee"
                                                                           class="checkboxes"
                                                                           value="{{ $key->id }}"/>
                                                                    <span></span>
                                                                </label>
                                                            </td>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $key->name }}</td>
                                                            <td>{{ $key->employer }}</td>
                                                            <td> {{ $key->business_manager }}</td>
                                                            <td>{{ $key->job_title }}</td>
                                                            <td> {{ $key->birthdate }}</td>
                                                            <td>{{ $key->mobile_no }}</td>
                                                            <td>{{ $key->nric_no }}</td>
                                                            <td>{{ 'Not yet available' }}</td>
                                                            <td>{{ $key->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Submit</button>
                                                <button type="button" class="btn default">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#recipient-form-list').DataTable({
            autoFill: true,
            "searching": false,
            "bPaginate": true,
            "paging":   false,
            "info":     false,
            "sScrollXInner": "100%",
            "scrollY":"500",
            "scrollX" : true

        });

        $('#select-group, #select-employer ').DataTable({
            autoFill: true,
            "scrollY":"200",
            "searching": false,
            "bPaginate": false,
            "paging":   false,
            "info":     false,
            "sScrollXInner": "100%"
        });
    });
</script>
@stop
