@extends('layouts.app')

@section('content')
    @foreach($list as $value)
        <form id="processed-{{ $value->schedule_id }}"
              action="{{ route('payout.processed',['id' => $value->schedule_id, 'userId' => $value->user_id]) }}"
              method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" name="processed" value="Pay">
        </form>
    @endforeach
    <div class="page-content-wrapper payout-list">
        <div class="page-content">
            @if($errors->has('multicheck'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong> Something went wrong. Please select data before making changes.
                </div>
            @endif
            <form action="{{ route('payout.multiple')  }}" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">Payouts</span>
                                </div>
                                <div class="actions">
                                    <a href="/payout/lists?payment-status=pending" class="btn sbold green"> Pending</a>
                                    <a href="/payout/lists?payment-status=processed" class="btn sbold green"
                                       value="Processed">Processed </a>
                                </div>
                                <div class="pay-job">
                                    <input class="btn sbold red" name="multiple" value="Pay" type="submit"/>
                                    {{--<a href="/payout/lists?payment-status=processed" class="btn sbold red"--}}
                                       {{--value="Processed">Pay</a>--}}
                                </div>
                            </div>
                            <div class="portlet-body employer-details-table">

                                <div>
                                    <div style="width: 40%; display: inline-block;">
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" id="min" placeholder="FROM">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="width: 40%; display: inline-block;">
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" id="max" placeholder="TO">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: inline-block; vertical-align: top;">
                                        <button type="button" class="btn btn-info" onclick="filter($('#min').val(), $('#max').val())">Apply</button>
                                    </div>
                                </div>

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
                                        <th>#</th>
                                        <th>Employer</th>
                                        <th>Jobseeker</th>
                                        <th>Job Salary</th>
                                        <th>Total Job Hours</th>
                                        <th>Hourly Rate</th>
                                        <th>Job Date</th>
                                        <th>Business Manager</th>
                                        <th>NRIC No.</th>
                                        <th>Job Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $value)
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" value="{{ $value->schedule_id }}" name="multicheck[]"
                                                           class="checkboxes"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->job_salary }}</td>
                                            <td>{{ $value->working_hours }}</td>
                                            <td>{{ $value->rate }}</td>
                                            <td>{{ $value->start_date }}</td>
                                            <td>{{ $value->business_manager }}</td>
                                            <td>{{ $value->nric_no }}</td>
                                            <td>{{ $value->job_title }}</td>
                                            @if($value->payment_status == 'pending')
                                                <td>
                                                    <span class="label label-sm label-warning"> {{ ucfirst($value->payment_status) }} </span>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="label label-sm label-success"> {{ ucfirst($value->payment_status) }} </span>
                                                </td>
                                            @endif

                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{ route('payout.edit',['id' => $value->schedule_id]) }}">
                                                                <i class="fa fa-edit"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('payout.processed',['id' => $value->schedule_id, 'userId' => $value->user_id]) }}"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('{{'processed-'.$value->schedule_id }}').submit();">
                                                                <i class="fa fa-credit-card"></i> Pay</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            localStorage.setItem('viewtype', 'payout-list');
        });
    </script>

@endsection

@include('layouts.employee-datatables-include',['title'=>'Payouts'])