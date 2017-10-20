@extends('layouts.app')

@section('content')
    @foreach($job as $value)
        <form id="approve-{{ $value->id }}" action="{{ route('job.multiple',['id' => $value->id, 'param' => 'Approve' ]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Approve">
        </form>
        <form id="reject-{{ $value->id }}" action="{{ route('job.multiple',['id' => $value->id, 'param' => 'Reject' ]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Reject">
        </form>
        <form id="destroy-{{ $value->id }}" action="{{ route('job.multiple',['id' => $value->id,'param' => 'Delete']) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="multiple" value="Delete">
        </form>
        @endforeach
    <div class="page-content-wrapper employee-list">
        <div class="page-content">
            <form action="{{ route('job.multiple')  }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">list of Jobs</span>
                                </div>
                                {{ csrf_field() }}
                                <div class="actions">
                                    <input class="btn sbold green" name="multiple" value="Approve" type="submit"/>
                                    <input class="btn sbold green" name="multiple" value="Reject" type="submit"/>
                                    <input class="btn sbold green" name="multiple" value="Delete" type="submit"/>
                                    <a href="" id="sample_editable_1_new"
                                       class="btn sbold green"> Add New
                                        <i class="fa fa-plus"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="employee-table">
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
                                        <th>Job Name</th>
                                        <th> Employees Required</th>
                                        <th>Employees Applied</th>
                                        <th>Rate</th>
                                        <th> Job Date & Time</th>
                                        <th>Business Manager</th>
                                        <th> Job Location</th>
                                        <th> Status</th>
                                        <th> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($job as $value)
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" value="{{ $value->id }}" name="multicheck[]" class="checkboxes"/>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>{{ $value->id }}</td>
                                        <td><a href="{{ route('employer.details',['id' => $value->user_id ]) }}">{{ $value->company_name }} </a></td>
                                        <td>{{ $value->job_title }}</td>
                                        <td>{{ $value->no_of_person }}</td>
                                        <td><a href="#">0 </a></td>
                                        <td> {{ '$'.$value->rate.'/hr' }}</td>
                                        <td> {{ Carbon\Carbon::parse($value->start_date)->format('H:i:s d-m-Y') }}</td>
                                        <td> {{ $value->business_manager }}</td>
                                        <td>{{ $value->location }}</td>

                                        @if($value->status == 'inactive')

                                            <td><span class="label label-sm label-danger"> Need to Approve </span></td>

                                        @elseif($value->status == 'active')
                                            <td>
                                                <span class="label label-sm label-success">{{ ucfirst($value->status) }} </span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="label label-sm label-waring">{{ ucfirst($value->status) }} </span>
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
                                                        <a href="{{ route('job.multiple',['id' =>  $value->id, 'param' =>'Delete' ]) }}"
                                                           onclick="event.preventDefault();
                                                                   document.getElementById('{{'destroy-'.$value->id }}').submit();">
                                                            <i class="fa fa-trash"></i> Delete</a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <i class="fa fa-edit"></i> Edit </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('job.details',['id' =>  $value->id])  }}">
                                                            <i class="fa fa-eye"></i> View </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('job.multiple',['id' =>  $value->id, 'param' => 'Approve'])  }}"
                                                           onclick="event.preventDefault();
                                                                   document.getElementById('{{'approve-'.$value->id }}').submit();">
                                                            <i class="fa fa-check-square-o"></i> Approve</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('job.multiple',['id' =>  $value->id, 'param' => 'Reject']) }}"
                                                           onclick="event.preventDefault();
                                                                   document.getElementById('{{'reject-'.$value->id }}').submit();">
                                                            <i class="fa fa-close"></i> Reject
                                                        </a>
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
@endsection
