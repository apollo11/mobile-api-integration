@extends('layouts.app')

@section('content')
    @foreach ($employee as $k=>$v)
        <form id="approve-{{ $v['id'] }}" action="{{ route('employee.approve',['id' => $v['id']]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <form id="upload-{{ $v['id'] }}" action="{{ route('employee.upload',['id' => $v['id']]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" value="Upload">
        </form>

        <form id="reject-{{ $v['id'] }}" action="{{ route('employee.reject',['id' => $v['id']]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" value="Reject">
        </form>
        <form id="destroy-{{ $v['id'] }}" action="{{ route('employee.destroy-one',['id' => $v['id']]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="submit" value="Delete">
        </form>
    @endforeach

    <div class="page-content-wrapper employee-list">
        <div class="page-content">
            @if($errors->has('multicheck'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Something went wrong. Please select data before making changes.
            </div>
            @endif

            <form action="{{ route('employee.destroy-all')  }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">Employees</span>
                                </div>
                                {{ csrf_field() }}
                                @if(Auth::user()->role_id == 0)
                                    <div class="actions">
                                        <input class="btn sbold green" name="multiple" value="Approve" type="submit"/>
                                        <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
                                        <a href="{{ route('employee.create') }}" id="sample_editable_1_new"
                                           class="btn sbold green"> Add New
                                            <i class="fa fa-plus"></i>
                                        </a>

                                    </div>
                                @endif
                            </div>
                            <div class="portlet-body job-lists-table">
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
                                                <input id ="group-checkable" type="checkbox" class="group-checkable"
                                                       data-set="#employee-table .checkboxes"/>
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>Name</th>
                                        <th>NRIC</th>
                                        @if($logged_in_role=='Administrator')
                                        <th>Contact No.</th>
                                        @endif

                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <!-- <th>Ratings</th> -->
                                        <th>Business Manager</th>
                                        <th>Jobs applied</th>
                                        <th>Jobs completed</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($employee as $k=>$v)
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" id="multicheck" name="multicheck[]" class="checkboxes"
                                                           value="{{ $v['id'] }}"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td><a href="{{ route('employee.details',['id' => $v['id']])  }}"> {{ $v['name'] }} </a></td>
                                            <td>
                                                {{ $v['nric_no'] }}
                                            </td>
                                            @if($logged_in_role=='Administrator')
                                            <td>{{ $v['mobile_no'] }}</td>
                                            @endif
                                            <td> {{ $v['gender'] }}</td>
                                            <td data-order="{{ Carbon\Carbon::parse($v['birthdate'])->format('m-d-Y H:i:s') }}">{{ Carbon\Carbon::parse($v['birthdate'])->format('m-d-Y H:i:s') }}</td>
                                            
                                            <td>{{$v['business_manager']}}</td>

                                            <td> <a href="{{ route('employee.details',['id' => $v['id']])  }}"> {{ $v['applied']  }} </a></td>
                                            <td><a href="{{ route('employee.details',['id' => $v['id']])  }}"> {{ $v['completed'] }} </a></td>

                                            @if($v['employee_status'] == 'pending')
                                                <td><span class="label label-sm label-warning"> Pending </span></td>

                                            @elseif($v['employee_status'] == 'reject')
                                                <td>
                                                    <span class="label label-sm label-danger">{{ ucfirst($v['employee_status']) }} </span>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="label label-sm label-success">{{ ucfirst($v['employee_status']) }} </span>
                                                </td>
                                            @endif
                                            <td class="center"> {{ $v['joined'] }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false"> Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    @if(Auth::user()->role_id == 0)
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{ route('employee.destroy-one',['id' => $v['id']]) }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'destroy-'.$v['id'] }}').submit();">
                                                                    <i class="fa fa-trash"></i> Delete</a>
                                                            </li>
                                                            <li>

                                                                <a href="{{ route('employee.edit',['id' => $v['id']])  }}">
                                                                    <i class="fa fa-edit"></i> Edit </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('employee.details',['id' => $v['id']])  }}">
                                                                    <i class="fa fa-eye"></i> View </a>
                                                            </li>

                                                            @if($v['employee_status'] != 'reject' && $v['employee_status'] != 'approved')
                                                            <li>
                                                                <a href="{{ route('employee.approve',['id' => $v['id']])  }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'approve-'.$v['id'] }}').submit();">
                                                                    <i class="fa fa-check-square-o"></i> Approve</a>
                                                            </li>
                                                            @endif

                                                            @if($v['employee_status'] != 'upload')
                                                            <li>
                                                                <a href="{{ route('employee.upload',['id' => $v['id']]) }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'upload-'.$v['id'] }}').submit();">
                                                                    <i class="fa fa-folder-open"></i> Upload
                                                                </a>
                                                            </li>
                                                            @endif

                                                            @if($v['employee_status'] != 'reject' && $v['employee_status'] != 'approved')
                                                            <li>
                                                                <a href="{{ route('employee.reject',['id' => $v['id']]) }}"
                                                                   onclick="event.preventDefault();
                                                                           document.getElementById('{{'reject-'.$v['id'] }}').submit();">
                                                                    <i class="fa fa-close"></i> Reject
                                                                </a>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                    @endif
                                                    @if(Auth::user()->role_id == 1)
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{ route('employee.details',['id' => $v['id']])  }}">
                                                                    <i class="fa fa-eye"></i> View </a>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
            </form>
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function() {
        // console.log('1');
        localStorage.setItem('viewtype', 'employee-list');
        // console.log(localStorage.getItem('viewType'));
    });
</script>
@endsection

@section('custom_page_css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@stop

@section('custom_page_js')
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/filtering/row-based/range_dates.js"></script> -->
<script>
    var table;
    var startDate;
    var endDate;
    var columnDateIndex;
    $(document).ready(function() {
        columnDateIndex = 0;
        table = $('#employee-table').DataTable({
            dom: 'Bfrtip',
            @if(!isset($exportbtn) || $exportbtn)
            buttons: [
                { "extend": 'excel', "text":'Export',"className": 'btn sbold red' @if(!empty($title)) ,"title" : "{{ $title }}" @endif  }
            ],
            @endif

            "aoColumnDefs": [
              { "bSearchable": false, "aTargets": [ 11 ] }
            ],
            autoFill: true,
    
            "scrollY":"500",
            "scrollX" : true,
            "sScrollXInner": "100%",
        });
    });


    // Date range filter
    function filter(startdate, enddate)
    {
        console.log('Date Filter Called');

        var viewType = localStorage.getItem('viewtype');
        console.log(viewType);
        if (viewType == "employee-list") {
            columnDateIndex = 5;
        }
        else if (viewType == "employee-details") {
            columnDateIndex = 2;
        }
        else if (viewType == "employer-details") {
            columnDateIndex = 7;
        }
        else if (viewType == "payout-list") {
            columnDateIndex = 7;
        }
        else if (viewType == "job-list") {
            columnDateIndex = 7;
        }
        else if (viewType == "job-details") {
            columnDateIndex = 4;
        }
        else if (viewType == "pushnotification-list") {
            columnDateIndex = 3;
        }
        else if (viewType == "recipient-list") {
            columnDateIndex = 3;
        }
        else {
            columnDateIndex = 0;
        }

        startDate = new Date(startdate.toString());
        endDate = new Date(enddate.toString());

        console.log(startDate);
        console.log(endDate);

        if (startDate > endDate) {
            console.log('invalid selection');
            $('#myModal').modal('show');
            return true;
        }
        else {
            table.draw();   
        }
    }


     $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            
            var min = $('#min').val();
            var max = $('#max').val();
            // new Date('00:00:00 01-01-2018');
            // var max = new Date('00:00:00 11-03-2018');

            if (min == null || max == null || min == '' || max == '') {
                return true;
            }
            min = new Date(min);
            max = new Date(max);

            var columnDate = new Date(data[columnDateIndex]);   
 
            if (columnDate >= min && columnDate <= max)
            {
                console.log('Filtered Date ==> ', columnDate);
                return true;
            }
            return false;
        }
    );


</script>

@include('layouts.invalid-date')
@stop