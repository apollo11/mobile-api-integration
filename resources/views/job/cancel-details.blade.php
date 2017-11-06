@extends('layouts.app')
@section('content')
    {{ dd($details) }}
    <div class="page-content-wrapper employee-details">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('job.lists')  }}">Jobs</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Details</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Job Details</span>
                            </div>
                            <div class="actions">
                                <a class="btn sbold green"
                                   href="{{ url()->previous()  }}">
                                    Back</a>
                                <a class="btn sbold green" href="#" class="btn" data-toggle="modal"
                                   data-target="#job-assigned">Assign Job</a>

                                <input class="btn sbold green" name="multiple" onclick="window.print()" value="Print"
                                       type="submit"/>
                            </div>
                        </div>
                        {{--<div class="portlet-body">--}}
                            {{--<div class="table-toolbar">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="btn-group">--}}
                                            {{--<div class="portlet-body">--}}
                                                {{--<div class="table-scrollable">--}}
                                                    {{--<table class="table table-hover">--}}
                                                        {{--<tbody>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Job Image</strong></td>--}}
                                                            {{--<td><img src="/{{ $details->job_image_path }}"--}}
                                                                     {{--width="200px"/></td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Company Name: </strong></td>--}}
                                                            {{--<td>{{ $details->company_name }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Business Manager </strong></td>--}}
                                                            {{--<td>{{ $details->business_manager }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Role</strong></td>--}}
                                                            {{--<td>{{ $details->role }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Job Description: </strong></td>--}}
                                                            {{--<td>{{ $details->job_description }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Job Location: </strong></td>--}}
                                                            {{--<td>{{ $details->location }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Job Industry: </strong></td>--}}
                                                            {{--<td>{{ $details->industry }}</td>--}}

                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Contact No.: </strong></td>--}}
                                                            {{--<td>{{ $details->contact_no }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Gender Needed: </strong></td>--}}
                                                            {{--<td>{{ $details->choices }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Rate:</strong></td>--}}
                                                            {{--<td>${{ $details->rate }}/hr</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Nationality:</strong></td>--}}
                                                            {{--<td>{{ ucfirst($details->nationality) }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Job Requirements </strong></td>--}}
                                                            {{--<td>{{ $details->job_requirements }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Notes</strong></td>--}}
                                                            {{--<td>{{ $details->notes }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td><strong>Language</strong></td>--}}
                                                            {{--<td>${{ $details->language }}/hr</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>Status</td>--}}
                                                            {{--@if($details->status == 'inactive')--}}
                                                                {{--<td><span class="label label-sm label-danger">Need to Approve</span>--}}
                                                                {{--</td>--}}
                                                            {{--@elseif($details->status == 'active')--}}
                                                                {{--<td>--}}
                                                                    {{--<span class="label label-sm label-success">{{ ucfirst($details->status) }} </span>--}}
                                                                {{--</td>--}}
                                                            {{--@else--}}
                                                                {{--<td>--}}
                                                                    {{--<span class="label label-sm label-waring">{{ ucfirst($details->status) }} </span>--}}
                                                                {{--</td>--}}
                                                            {{--@endif--}}
                                                        {{--</tr>--}}
                                                        {{--</tbody>--}}
                                                    {{--</table>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection